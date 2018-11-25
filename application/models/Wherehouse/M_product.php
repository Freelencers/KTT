 <?php
class M_product extends CI_Model {

    public function getProductDetailById($productID){

        $result = $this->db->select("matId,matName,matCode,matUntId,matMin,matMax,matType,matLocId,matUntId")
        ->from("material")
        ->join("location",'matUntId = locId', "inner")
        ->join("unit",'matUntId = untId', "inner")
        ->where("matId",$productID);

        return $this->db->get();
    }
    public function getProductList($currentPage,$limitPage,$search,$matType="",$orlimit){

        $offset = ($currentPage-1)*$limitPage;
        $result = $this->db->select("matCode, matId,matName,matCode,untName,matMin,matMax,matType,locName")
        ->from("material")
        ->join("location",'matLocId = locId', "inner")
        ->join("unit",'matUntId = untId', "inner")
        ->where("matDeleteBy IS NULL");

        if($matType){

            $this->db->where("matType",$matType);
        }
    
        if($search){ 
            $this->db->group_start();
            $this->db->like('matId', $search);
            $this->db->or_like('matName', $search);
            $this->db->or_like('matCode', $search);
            $this->db->or_like('matUntId', $search);
            $this->db->or_like('matMin', $search);
            $this->db->or_like('matMax', $search);
            $this->db->or_like('matType', $search);
            $this->db->group_end();
        }
        if($orlimit == "dataList"){
            $this->db->order_by("matId", "DESC")
            ->limit($limitPage, $offset);    
        }
        return $this->db->get();
    }

    public function getAllRows($search,$matType=""){

        $result = $this->db->select("matId")
        ->from("material")
        ->join("location",'matLocId = locId', "inner")
        ->join("unit",'matUntId = untId', "inner")
        ->where("matDeleteBy IS NULL");

        if($matType){

            $this->db->where("matType",$matType);
        }
    
        if($search){ 
            $this->db->group_start();
            $this->db->like('matId', $search);
            $this->db->or_like('matName', $search);
            $this->db->or_like('matCode', $search);
            $this->db->or_like('matUntId', $search);
            $this->db->or_like('matMin', $search);
            $this->db->or_like('matMax', $search);
            $this->db->or_like('matType', $search);
            $this->db->group_end();
        }
        return $this->db->get()->num_rows();
    }

    public function deleteProduct($matId){
        $sesUrl = $this->session->userdata("accId");
        $dataList = array(
            'matDeletedate' => date('Y-m-d H:i:s'),
            'matDeleteBy'  => $sesUrl 
         );
         $this->db->set($dataList);
         $this->db->where('matId', $matId); 

         $updateDate = $this->db->update('material');
         
         return $updateDate;
    }
    public function updateProduct($matId,$matName,$matType,$matMin,$matMax,$matLocId,$matUntId){

        $dataList = array(
            'matName' => $matName,
            'matType'  => $matType,
            'matMin'  => $matMin,
            'matMax'  => $matMax,
            'matLocId'  => $matLocId,
            'matUntId'  => $matUntId,
            'matUpdatedate' => date('Y-m-d H:i:s')
         );
         $this->db->set($dataList);
         $this->db->where('matId', $matId); 

         $updateDate = $this->db->update('material');

         return $updateDate;
    }
    public function createNewProduct($matName,$matCode,$matType,$matMin,$matMax,$matLocId,$matUntId){


        $dataList = array(
            'matName' => $matName,
            'matCode'  => $matCode,
            'matType'  => $matType,
            'matMin'  => $matMin,
            'matMax'  => $matMax,
            'matLocId'  => $matLocId,
            'matUntId'  => $matUntId,
            'marCreatedate' => date('Y-m-d H:i:s')
        );

        $this->db->trans_start();

        $insertDate = $this->db->insert('material',$dataList);
        $insertId = $this->db->insert_id();

        // Generate Code 
        $update["matCode"] = "MT" . str_pad($insertId, 5, "0");
        $this->db->where("matId", $insertId)
        ->update("material", $update);

        // create stock
        $stockData["stoMatId"]          = $insertId;
        $stockData["stoCreatedate"]     = date("Y-m-d H:i:s");
        $stockData["stoCreateBy"]       = $this->session->userdata("accId");
        $stockData["stoAction"]         = "INPUT";
        $stockData["stoActualStock"]    = 0;
        $stockData["stoVirtualStock"]   = 0;
        $stockData["stoLast"]           = 1;
        $stockData["stoLocId"]          = $matLocId;
        $stockData["stoAmount"]         = 0;
        $stockData["stoCost"]           = 0;
        $stockData["stoUsed"]           = 0;
        $this->db->insert("stock", $stockData);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function getUnitList($search){

        $this->db->select("*")
        ->from("unit");

        if($search){

            $this->db->like("untName", $search);
        }

        return $this->db->get();
    }


}
?>
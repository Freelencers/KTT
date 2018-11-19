 <?php
class M_product extends CI_Model {

    public function getProductDetailById($prdId){

        $result = $this->db->select("prdId, prdMatId, prdPoint, prdFullPrice, prdDiscount, prdPoint, (prdFullPrice - prdDiscount) AS prdTotal, matName")
        ->from("product")
        ->join("material", "matId = prdMatId", "inner")
        ->where("prdId",$prdId);

        return $this->db->get();
    }
    public function getProductList($currentPage,$limitPage,$search,$matType="",$orlimit){

       
        $result = $this->db->select("matCode AS prdMatCode, matName AS prdMatName, prdId, prdMatId")
        ->from("product")
        ->join("material",'matId = prdMatId', "inner")
        ->where("prdDeleteBy IS NULL");

        if($matType){

            $this->db->where("matType",$matType);
        }
    
        if($search){ 

            $this->db->group_start();
            $this->db->like('matName', $search);
            $this->db->group_end();
        }

        if($orlimit == "LIMIT"){
            
            $offset = ($currentPage-1)*$limitPage;
            $this->db->order_by("prdId", "DESC")
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

    public function deleteProduct($prdId){

        $accId = $this->session->userdata("accId");
        $dataList = array(
            'prdDeletedate' => date('Y-m-d H:i:s'),
            'prdDeleteBy'  => $accId 
         );
         $this->db->set($dataList);
         $this->db->where('prdId', $prdId); 

         $updateDate = $this->db->update('product');
         
         return $updateDate;
    }

    public function updateProductDetail($prdId, $prdCost, $prdFullPrice, $prdDiscount, $prdPoint, $prdMatId){

        $dataList = array(
            'prdFullPrice'  => $prdFullPrice,
            'prdDiscount'   => $prdDiscount,
            'prdPoint'      => $prdPoint,
            'prdCreateBy'   => $this->session->userdata("accId"),
            'prdCreatedate' => date('Y-m-d H:i:s')
        );


        $this->db->trans_start();

        $this->db->set($dataList);
        $this->db->where('prdId', $prdId); 
        $this->db->update('product');
        
         // Create price log 
        $productPrice["pdpDiscount"]    = $prdDiscount; 
        $productPrice["pdpPoint"]       = $prdPoint;
        $productPrice["pdpCreatedate"]  = date("Y-m-d H:i:s");
        $productPrice["pdpPrdId"]       = $prdId;
        $this->db->insert("productPrice", $productPrice);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    public function createNewProduct($prdFullPrice, $prdDiscount, $prdPoint, $prdMatId){

        $dataList = array(
            'prdFullPrice'  => $prdFullPrice,
            'prdDiscount'   => $prdDiscount,
            'prdPoint'      => $prdPoint,
            'prdMatId'      => $prdMatId,
            'prdCreateBy'   => $this->session->userdata("accId"),
            'prdCreatedate' => date('Y-m-d H:i:s')
        );

        //echo $prdMatId;

        $this->db->trans_start();

        $insertDate = $this->db->insert('product',$dataList);
        $insertId = $this->db->insert_id();

        // Create price log 
        $productPrice["pdpDiscount"]    = $prdDiscount; 
        $productPrice["pdpPoint"]       = $prdPoint;
        $productPrice["pdpCreatedate"]  = date("Y-m-d H:i:s");
        $productPrice["pdpPrdId"]       = $insertId;
        $this->db->insert("productPrice", $productPrice);

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
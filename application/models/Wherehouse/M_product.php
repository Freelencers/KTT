 <?php
class M_product extends CI_Model {

    public function getProductDetailById($productID){

        $result = $this->db->select("matId,matName,matCode,matUntId,matMin,matMax,matType")
        ->from("material")
        ->join("location",'matId = locId')
        ->join("unit",'matId = untId')
        ->where("matId",$productID);

        return $this->db->get();
    }
    public function getProductList($currentPage,$limitPage,$search,$matType,$orlimit){
        $offset = ($currentPage-1)*$limitPage;
        $result = $this->db->select("matId,matName,matCode,matUntId,matMin,matMax,matType")
        ->from("material")
        ->join("location",'matId = locId')
        ->join("unit",'matId = untId')
        ->where("matType",$matType)
        ->where("matDeleteBy IS NULL");
    
        if($search){ 
            $this->db->group_start();
            $this->db->like('%matId%', $search);
            $this->db->or_like('%matName%', $search);
            $this->db->or_like('%matCode%', $search);
            $this->db->or_like('%matUntId%', $search);
            $this->db->or_like('%matMin%', $search);
            $this->db->or_like('%matMax%', $search);
            $this->db->or_like('%matType%', $search);
            $this->db->group_end();
        }
        if($orlimit == "dataList"){
            $this->db->limit($limitPage, $offset);    
        }
        return $this->db->get();
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
    public function updateProduct($matId,$matName,$matCode,$matType,$matMin,$matMax,$matLocId,$matUntId){

        $dataList = array(
            'matName' => $matName,
            'matCode'  => $matCode,
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
        $insertDate = $this->db->insert('material',$dataList);

        return $insertDate;

    }

}
?>
<?php
class Product extends CI_controller {
    
    public function __construct()
    {
               parent::__construct();
               // Your own constructor code
               $this->load->model("Wherehouse/M_product");
    }

    public function getProductDetailById(){
        
        $productID  = $this->input->post("matId");
        $result = $this->M_product->getProductDetailById($productID);
        $result = $result->result();

        $json["status"]="";
        $json["msg"]="";
        $json["response"]["dataRow"]= $result;
        echo json_encode($json);
    }
    public function getProductList(){
        $currentPage  = $this->input->post("currentPage");
        $limitPage   = $this->input->post("limitPage");
        $search   = $this->input->post("search");
        $matType   = $this->input->post("matType");
       // $result = $this->M_product->getProductList();
       $limitDataList = "dataList";
       $limitPagination = "pagination";
       
       $resultData = $this->M_product->getProductList($currentPage,$limitPage,$search,$matType,$limitDataList);
       $resultData = $resultData->result();

       $resultPage = $this->M_product->getProductList($currentPage,$limitPage,$search,$matType,$limitPagination);
       $resultPage = $resultPage->result();



       $json["status"]="";
       $json["msg"]="";
       $json["response"]["pagination"]= genPagination($currentPage, $resultPage);
       $json["response"]["dataList"]= $resultData;

       echo json_encode($json);
    }
    public function deleteProduct(){
        $matId  = $this->input->post("matId");
        $resultData = $this->M_product->deleteProduct($matId);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        } else {
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
        
    }
    public function updateProduct(){
        $matId  = $this->input->post("matId");
        $matName = $this->input->post("matName");
        $matCode  = $this->input->post("matCode");
        $matType  = $this->input->post("matType");
        $matMin  = $this->input->post("matMin");
        $matMax  = $this->input->post("matMax");
        $matLocId  = $this->input->post("matLocId");
        $matUntId  = $this->input->post("matUntId");

        $resultData = $this->M_product->updateProduct($matId,$matName,$matCode,$matType,$matMin,$matMax,$matLocId,$matUntId);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($resultData);
        } else {
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($resultData);
        }
        
    }
    public function createNewProduct(){
        $matName = $this->input->post("matName");
        $matCode  = $this->input->post("matCode");
        $matType  = $this->input->post("matType");
        $matMin  = $this->input->post("matMin");
        $matMax  = $this->input->post("matMax");
        $matLocId  = $this->input->post("matLocId");
        $matUntId  = $this->input->post("matUntId");

        $resultData = $this->M_product->createNewProduct($matName,$matCode,$matType,$matMin,$matMax,$matLocId,$matUntId);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($resultData);
        } else {
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($resultData);
        }
    }
}
?>
<?php
class Product extends CI_controller {
    
    public function __construct()
    {
               parent::__construct();
               // Your own constructor code
               $this->load->model("Account/M_product");
    }

    public function getProductDetailById(){
        
        $prdId  = $this->input->post("prdId");
        $result = $this->M_product->getProductDetailById($prdId);
        $result = $result->row();

        $json["status"] = 200;
        $json["msg"]    = "Success";
        $json["response"]["dataRow"]= $result;
        echo json_encode($json);
    }

    public function getProductList(){
        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");
        $matType        = $this->input->post("matType");

       $resultData = $this->M_product->getProductList($currentPage,$limitPage,$search,$matType, "LIMIT");
       $resultData = $resultData->result();

       $allRows = $this->M_product->getProductList($currentPage,$limitPage,$search,$matType, "ALL")->num_rows();
       $allPage = ceil($allRows / $limitPage);

       $json["status"] = 200;
       $json["msg"] = "Success";
       $json["response"]["pagination"]= genPagination($currentPage, $allPage);
       $json["response"]["dataList"]= $resultData;

       echo json_encode($json);
    }

    public function deleteProduct(){

        $prdId  = $this->input->post("prdId");
        $resultData = $this->M_product->deleteProduct($prdId);

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
    public function updateProductDetail(){

        $prdId          = $this->input->post("prdId");
        $prdCost        = $this->input->post("prdCost");
        $prdFullPrice   = $this->input->post("prdFullPrice");
        $prdDiscount    = $this->input->post("prdDiscount");
        $prdPoint       = $this->input->post("prdPoint");
        $prdMatId       = $this->input->post("prdMatId");

        $resultData = $this->M_product->updateProductDetail($prdId, $prdCost, $prdFullPrice, $prdDiscount, $prdPoint, $prdMatId);

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
    public function createNewProduct(){

        $prdFullPrice   = $this->input->post("prdFullPrice");
        $prdDiscount    = $this->input->post("prdDiscount");
        $prdPoint       = $this->input->post("prdPoint");
        $prdMatId       = $this->input->post("prdMatId");

        $resultData = $this->M_product->createNewProduct($prdFullPrice, $prdDiscount, $prdPoint, $prdMatId);

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

    public function getUnitList(){

        $search = $this->input->post("search");
        $result = $this->M_product->getUnitList($search);

        if($result) {

            $json['status'] = 200;
            $json['msg'] = "Success";
            $json['response']["dataList"] = $result->result();
            echo json_encode($json);
        }else{

            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
    }
}
?>
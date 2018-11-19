<?php
class Order extends CI_controller {
    
    public function __construct()
    {
               parent::__construct();
               // Your own constructor code
               $this->load->model("Account/M_order");
    }

    public function getProductList(){

        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");
        $matType        = $this->input->post("matType");

        $limitDataList = "dataList";
        $limitPagination = "pagination";
        
        $resultData = $this->M_order->getProductList($currentPage,$limitPage,$search,$matType,$limitDataList);
        $resultData = $resultData->result();
 
        $allRows = $this->M_order->getProductList($currentPage,$limitPage,$search,$matType, "ALL")->num_rows();
        $allPage = ceil($allRows / $limitPage);
 
        $json["status"] = 200;
        $json["msg"] = "Success";
        $json["response"]["pagination"]= genPagination($currentPage, $allPage);
        $json["response"]["dataList"]= $resultData;
 
        echo json_encode($json);
    }


    public function getMyOrderList(){

        $ordId          = $this->input->post("ordId");
        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");


        $myOrder = $this->M_order->getMyOrderList($ordId, $currentPage,$limitPage,$search, "LIMIT")->result();

        $allRows = $this->M_order->getMyOrderList($ordId, $currentPage,$limitPage,$search, "ALL")->num_rows();
        $allPage = round($allRows / $limitPage);

        $json["status"] = 200;
        $json["msg"] = "Success";
        $json["response"]["pagination"]= genPagination($currentPage, $allPage);
        $json["response"]["dataList"]= $myOrder;

        echo json_encode($json);
    }

    public function addToCart(){

        $sodOrdId = $this->input->post("sodOrdId");
        $sodPrdId = $this->input->post("sodPrdId");
        $sodQty   = $this->input->post("sodQty");

        $result = $this->M_order->addToCart($sodOrdId, $sodPrdId, $sodQty);

        if($result){

            $json["status"] = 200;
            $json["msg"] = "success";
        }else{
        
            $json["status"] = 200;
            $json["msg"] = "error";
        }

        echo json_encode($json);
    }

    public function getOrderList(){

        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");


        $myOrder = $this->M_order->getOrderList($currentPage,$limitPage,$search, "LIMIT")->result();

        $allRows = $this->M_order->getOrderList($currentPage,$limitPage,$search, "ALL")->num_rows();
        $allPage = ceil($allRows / $limitPage);

        $json["status"] = 200;
        $json["msg"] = "Success";
        $json["response"]["pagination"]= genPagination($currentPage, $allPage);
        $json["response"]["dataList"]= $myOrder;

        echo json_encode($json);
    }

    public function getInvoiceDetail(){

        $ordId = $this->input->post("ordId");
        $result = $this->M_order->getInvoiceDetail($ordId);

        echo json_encode($result);

    }
}
?>
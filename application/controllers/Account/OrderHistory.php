<?php
class OrderHistory extends CI_controller {
    
    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
        $this->load->model("Account/M_orderHistory");
    }

    public function getOrderHistory(){

        $currentPage    = $this->input->post("currentPage");
        $limitPage      = $this->input->post("limitPage");
        $search         = $this->input->post("search");

        $resultData = $this->M_orderHistory->getOrderHistory($currentPage, $limitPage, $search, "LIMIT");
        $resultData = $resultData->result();
 
        $allRows = $this->M_orderHistory->getOrderHistory($currentPage, $limitPage, $search, "ALL")->num_rows();
        $allPage = ceil($allRows / $limitPage);
 
        $json["status"] = 200;
        $json["msg"] = "Success";
        $json["response"]["pagination"]= genPagination($currentPage, $allPage);
        $json["response"]["dataList"]= $resultData;
 
        echo json_encode($json);
    }
}

?>
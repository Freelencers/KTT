<?php
class Stock extends CI_controller {
    
    public function __construct()
    {
               parent::__construct();
               // Your own constructor code
               $this->load->model("Wherehouse/M_stock");
    }

    public function getStockList(){

        $currentPage = $this->input->post("currentPage");
        $limitPage = $this->input->post("limitPage");
        $search = $this->input->post("search");
        $stockCondition = $this->input->post("stockCondition");

        $dataList = $this->M_stock->getStockList($currentPage, $limitPage, $search, $stockCondition);
        $dataList = $dataList->result();

        $allRows = $this->M_stock->getStockList($currentPage, 0, $search, $stockCondition);
        $allPage = round($allRows->num_rows() / $limitPage);

        $json["status"] = 200;
        $json["msg"] = "success";
        $json['response']['pagination'] = genPagination( $currentPage, $allPage);
        $json['response']['dataList'] = $dataList;

        echo json_encode($json);
    }


    public function inputStock(){

        $matId      = $this->input->post("matId");
        $matCost    = $this->input->post("matCost");
        $matAmount  = $this->input->post("matAmount");
        $matLocId   = $this->input->post("matLocId");
        $matExpDate = $this->input->post("matExpDate");
        $stoReason  = $this->input->post("stoReason");

        $result = $this->M_stock->inputStock($matId, $matCost, $matAmount, $matLocId, $matExpDate, $stoReason);

        if($result) {

            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        } else {

            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
    }

    public function outputStock(){
        $matId      = $this->input->post("matId");
        $matLocId   = $this->input->post("matLocId");
        $matAmount  = $this->input->post("matAmount");
        $stoReason  = $this->input->post("stoReason");

        $result = $this->M_stock->outputStock($matId, $matLocId, $matAmount, $stoReason);
        if($result) {

            $json['status'] = 200;
            $json['msg'] = "Success";
        } else {

            $json['status'] = 200;
            $json['msg'] = "Error";
        }

        echo json_encode($json);
    }

    public function getStockHistoryList(){

        $currentPage = $this->input->post("currentPage");
        $limitPage = $this->input->post("limitPage");
        $search = $this->input->post("search");

        $dataList = $this->M_stock->getStockHistoryList($currentPage, $limitPage, $search);
        $dataList = $dataList->result();

        $allRows = $this->M_stock->getStockHistoryList($currentPage, 0, $search);
        $allPage = round($allRows->num_rows() / $limitPage);

        $json["status"] = 200;
        $json["msg"] = "success";
        $json['response']['pagination'] = genPagination( $currentPage, $allPage);
        $json['response']['dataList'] = $dataList;

        echo json_encode($json);
    }

    public function getProductStockDetail(){

        $matId          = $this->input->post("matId");
        $locationMode   = $this->input->post("locationMode");
        $dataRow        = $this->M_stock->getProductStockDetail($matId, $locationMode);

        $json["status"] = 200;
        $json["msg"] = "success";
        $json['response']['dataRow'] = $dataRow;

        echo json_encode($json);
    }

    public function getLastCost(){

        $matId = $this->input->post("matId");
        $result = $this->M_stock->getLastCost($matId)->row();
        $json["response"]["lastCost"] = $result->stoCost;

        echo json_encode($json);
    }
}
?>
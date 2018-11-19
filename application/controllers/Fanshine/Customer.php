<?php
class Customer extends CI_controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Fanshine/M_customer");
    }

    public function createNewCustomer(){

        $customerData   = $this->input->post("CustomerData");
        //$customerDataJson = json_decode($customerData, true);

        $resultData = $this->M_customer->createNewCustomer($customerData);

        if($resultData) {

            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        }else{

            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }

        //echo json_encode($this->M_general->getSettingValue());
    }

    public function updateCustomerDetail(){

        $customerData   = $this->input->post("CustomerData");

        $resultData = $this->M_customer->updateCustomerDetail($customerData);

        if($resultData) {

            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        }else{

            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
    }

    public function deleteCustomer(){

        $cusId      = $this->input->post("cusId");
        $resultData = $this->M_customer->deleteCustomer($cusId);

        if($resultData) {

            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        }else{

            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
    }

    public function getCustomerList(){

        $currentPage = $this->input->post("currentPage");
        $limitPage = $this->input->post("limitPage");
        $search = $this->input->post("search");

        $result = $this->M_customer->getCustomerList($currentPage, $limitPage, $search);

         if($result){

            $json["status"] = 200;
            $json["msg"] = "success";

            $allPage = round($this->M_customer->getCustomerAllRows() / $limitPage);
            $json["response"]["pagination"] = genPagination($currentPage, $allPage);

            // Initial status
            $result = $result->result();
            foreach($result as $index => $value){

                if($value->lvuDate < 60){

                    $result[$index]->cusStatus = "NEW";
                }else{

                    $result[$index]->cusStatus = "PRO";
                }
            }
            $json["response"]["dataList"] = $result;

         }else{

            $json["status"] = 200;
            $json["msg"] = "success";
         }

         echo json_encode($json);
    }

    public function upgradeCustomerLevel(){

        $cusId = $this->input->post("cusId");
        $cusLevel = $this->input->post("cusLevel");

        $result = $this->M_customer->upgradeCustomerLevel($cusId, $cusLevel);

        if($result){

            $json["status"] = 200;
            $json["msg"] = "success";
        }else{

            $json["status"] = 200;
            $json["msg"] = "error";
        }

        echo json_encode($json);
    }

    public function getCustomerDetailById(){

        $cusId  = $this->input->post("cusId");
        $result = $this->M_customer->getCustomerDetailById($cusId);

        if($result){

            $json["status"] = 200;
            $json["msg"] = "successs";
            $json["response"]["dataRow"] = $result;
        }else{

            $json["status"] = 200;
            $json["msg"] = "error";

        }

        echo json_encode($json);
    }

    public function getProvince(){

        $result = $this->M_customer->getProvince()->result();
        if($result){

            $json["status"] = 200;
            $json["msg"] = "successs";
            $json["response"]["dataList"] = $result;
        }else{

            $json["status"] = 200;
            $json["msg"] = "error";
            $json["response"]["dataList"] = array();
        }

        echo json_encode($json);
    }

    public function getDistrict(){

        $prvId = $this->input->post("disPrvId");
        $result = $this->M_customer->getDistrict($prvId)->result();
        if($result){

            $json["status"] = 200;
            $json["msg"] = "successs";
            $json["response"]["dataList"] = $result;
        }else{

            $json["status"] = 200;
            $json["msg"] = "error";
            $json["response"]["dataList"] = array();
        }

        echo json_encode($json);
    }

    public function getCountry(){

        $result = $this->M_customer->getCountry()->result();
        if($result){

            $json["status"] = 200;
            $json["msg"] = "successs";
            $json["response"]["dataList"] = $result;
        }else{

            $json["status"] = 200;
            $json["msg"] = "error";
            $json["response"]["dataList"] = array();
        }

        echo json_encode($json);
    }

    public function getBank(){
  
        $result = $this->M_customer->getBank()->result();
        if($result){

            $json["status"] = 200;
            $json["msg"] = "successs";
            $json["response"]["dataList"] = $result;
        }else{

            $json["status"] = 200;
            $json["msg"] = "error";
        }

        echo json_encode($json);
    }

    public function getRefer(){

        $search = $this->input->post("search");
        $except = $this->input->post("except");

        $result = $this->M_customer->getRefer($search, $except)->result();
        if($result){

            $json["status"] = 200;
            $json["msg"] = "successs";
            $json["response"]["dataList"] = $result;
        }else{

            $json["status"] = 200;
            $json["msg"] = "error";
            $json["response"]["dataList"] = array();
        }

        echo json_encode($json);
    }


}    
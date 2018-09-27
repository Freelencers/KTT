<?php
    class Account extends CI_controller
    {
        public function createNewAccount() {
            $accFirstname = $this->input->post("accFirstname");
            $accLastname  = $this->input->post("accLastname");
            $accUsername  = $this->input->post("accUsername");
            $accPassword  = $this->input->post("accPassword");

            $this->load->model("System/M_Account");
            $result = $this->M_Account->createNewAccount($accFirstname, $accLastname, $accUsername, $accPassword);
        }
        public function deleteAccount() {
            $accId = $this->input->post("accId");

            $this->load->model("System/M_Account");
            $result = $this->M_Account->deleteAccount($accId);
        }

        public function updateAccount() {
            $accId = $this->input->post("accId");
            $accFirstname = $this->input->post("accFirstname");
            $accLastname  = $this->input->post("accLastname");
            $accUsername  = $this->input->post("accUsername");
            $accPassword  = $this->input->post("accPassword");

            $this->load->model("System/M_Account");
            $result = $this->M_Account->updateAccount($accId, $accFirstname, $accLastname, $accUsername, $accPassword);
        }

        public function getAccountById() {
            $accId = $this->input->post("accId");

            $this->load->model("System/M_Account");
            $queryData = $this->M_Account->getAccountById($accId);
            $queryData = $queryData->result();
            $dataRow = json_decode(json_encode((object) $queryData[0]), FALSE);

            $json['status'] = 200;
            $json['msg'] = "hello";
            $json['response']['dataRow'] = $dataRow;

            echo json_encode($json);
        }

        public function getAllAccount() {
            $currentPage = $this->input->post("currentPage");
            $limitPage = $this->input->post("limitPage");
            $this->load->model("System/M_Account");
            $queryPages = $this->M_Account->countRowAccount($limitPage);
            $pages = $queryPages;
            $startPage = $currentPage-3;
            $endPage = $currentPage+3;
            
            if($startPage <= 0) {
                $startPage = 1;
            } 
            if($endPage > $pages) {
                $endPage = $pages;
            }
            $pagination = array();

            for($i = $startPage; $i <= $endPage; $i++){
                if($i == $currentPage){
                    $perPages = array (
                        "page" => $i,
                        "status" => "active"
                    );       
                } else {
                    $perPages = array (
                        "page" => $i,
                        "status" => ""
                    );
                }
                array_push($pagination, $perPages);
            }

            $queryData = $this->M_Account->getAllAccount($currentPage, $limitPage);
            $dataList = $queryData->result();
            
            $json['response']['pagination'] = $pagination;
            $json['response']['dataList'] = $dataList;
            echo json_encode($json);
        }
    }
?>
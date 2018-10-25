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
            
            $json["status"] = 200;
            $json["msg"] = "Success";
            echo json_encode($json);
        }
        public function deleteAccount() {
            $accId = $this->input->post("accId");

            $this->load->model("System/M_Account");
            $result = $this->M_Account->deleteAccount($accId);

            $json["status"] = 200;
            $json["msg"] = "Success";
            echo json_encode($json);
        }

        public function updateAccount() {
            $accId = $this->input->post("accId");
            $accFirstname = $this->input->post("accFirstname");
            $accLastname  = $this->input->post("accLastname");
            $accUsername  = $this->input->post("accUsername");
            $accPassword  = $this->input->post("accPassword");

            $this->load->model("System/M_Account");
            $result = $this->M_Account->updateAccount($accId, $accFirstname, $accLastname, $accUsername, $accPassword);
            
            $json["status"] = 200;
            $json["msg"] = "Success";
            echo json_encode($json);
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

            $queryData = $this->M_Account->getAllAccount($currentPage, $limitPage);
            $dataList = $queryData->result();
            
            $json['response']['pagination'] = genPagination($currentPage,$queryPages);
            $json['response']['dataList'] = $dataList;
            
            echo json_encode($json);
        }
    }
?>
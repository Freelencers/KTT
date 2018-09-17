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
            // $dataRow = json_decode(json_encode((object) $queryData[0]), FALSE);
            $dataRow = (object) $queryData[0];

            $json['status'] = 200;
            $json['msg'] = "hello";
            $json['response']['dataRow'] = $dataRow;

            echo json_encode($json);
        }
    }
?>
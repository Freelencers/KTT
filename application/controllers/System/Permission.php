<?php
    class Permission extends CI_controller
    {

        public function __construct(){

            parent::__construct();
            $this->load->model("System/M_Permission");
        }
        
        public function changePermission() {

            $accId = $this->input->post("accId");
            $modId = $this->input->post("modId");
            $access = $this->input->post("access");

            $changeResult = $this->M_Permission->changePermission($accId, $modId, $access);

            if($changeResult){

                $json["status"] = 200;
                $json["msg"] = "Success";
            }else{

                $json["status"] = 200;
                $json["msg"] = "Action to database false";
            }
            echo json_encode($json);
        }

        public function getModuleList(){

            $accId = $this->input->post("accId"); 
            $moduleList = $this->M_Permission->getModuleList($accId);

            $json["status"] = 200;
            $json["msg"] = "Success";
            $json["response"] = $moduleList;
            echo json_encode($json);
        }
    }
?>
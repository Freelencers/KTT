<?php
    class Permission extends CI_controller
    {
        public function changePermission() {

            $accId = $this->input->post("accId");
            $modId = $this->input->post("modId");
            $access = $this->input->post("access");

            $this->load->model("System/M_Permission");
            $changeResult = $this->M_Permission->changePermission($accId, $modId, $access);

            if($changeResult){

                $json["status"] = 200;
                $json["msg"] = "Success";
                $json["response"]["error"] = "";
            }
            echo json_encode($json);
        }
    }
?>
<?php
    class Setting extends CI_controller
    {

        public function getSetting() {
            
            $this->load->model("System/M_Setting");
            $setting = $this->M_Setting->getSetting();
            $setting = $setting->result();

            // Repare Response
            $json["status"] = 200;
            $json["msg"] = "Success";
            $json["response"] = $setting;

            echo json_encode($json);
        }

        public function getSettingHistory(){
            // Parameter
            $currentPage    = $this->input->post("currentPage");
            $limitPage      = $this->input->post("limitPage");
            $search         = $this->input->post("search");

            // create object 
            $this->load->model("System/M_Setting");

            // get data list 
            $setting = $this->M_Setting->getSettingHistory($currentPage, $limitPage, $search);
            $setting = $setting->result();

            // get page number
            $allPageNumber =  $this->M_Setting->getSettingHistoryPageNumber();

            // Repare Response
            $json["status"] = 200;
            $json["msg"] = "Success";
            $json["pagination"] = genPagination($currentPage, $allPageNumber);
            $json["response"]["dataList"] = $setting;

            echo json_encode($json);
        }

        public function getSettingSheduleList(){

            // Parameter
            $currentPage    = $this->input->post("currentPage");
            $limitPage      = $this->input->post("limitPage");
            $search         = $this->input->post("search");

            // create object 
            $this->load->model("System/M_Setting");

            // get data list 
            $setting = $this->M_Setting->getSettingScheduleList($currentPage, $limitPage, $search);
            $setting = $setting->result();

            // get page number
            $allPageNumber =  $this->M_Setting->getSettingHistoryPageNumber();

            // Repare Response
            $json["status"] = 200;
            $json["msg"] = "Success";
            $json["pagination"] = genPagination($currentPage, $allPageNumber);
            $json["response"]["dataList"] = $setting;

            echo json_encode($json);
        }
    }
?>
<?php
    class Setting extends CI_controller
    {
        public function __construct(){

            parent::__construct();
            $this->load->model("System/M_Setting");
        }
        public function getSetting() {
            
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

            // get data list 
            $setting = $this->M_Setting->getSettingHistory($currentPage, $limitPage, $search);
            $setting = $setting->result();

            // get page number
            $allPageNumber =  $this->M_Setting->getSettingHistoryPageNumber();

            // Repare Response
            $json["status"] = 200;
            $json["msg"] = "Success";
            $json["pagination"] = genPagination($currentPage, $allPageNumber);
            $json["response"]["dataList"] = $this->convertFormat($setting);

            echo json_encode($json);
        }

        public function getSettingSheduleList(){

            // Parameter
            $currentPage    = $this->input->post("currentPage");
            $limitPage      = $this->input->post("limitPage");
            $search         = $this->input->post("search");

            // get data list 
            $setting = $this->M_Setting->getSettingScheduleList($currentPage, $limitPage, $search);
            $setting = $setting->result();

            // get page number
            $allPageNumber =  $this->M_Setting->getSettingHistoryPageNumber();

            // Repare Response
            $json["status"] = 200;
            $json["msg"] = "Success";
            $json["pagination"] = genPagination($currentPage, $allPageNumber);
            $json["response"]["dataList"] = $this->convertFormat($setting);
            //$json["response"]["dataList"] = $setting;

            echo json_encode($json);
        }

        public function convertFormat($settingList){

            $ssgIdTemp = 0;
            $settingNewFormat = array();
            $index = -1;
            $round = 0;
            foreach($settingList as $row){

                if($row->ssgId != $ssgIdTemp){

                    $ssgIdTemp = $row->ssgId;
                    $index++;
                    
                    // initial data
                    $settingNewFormat[$index]["ssgId"]                  = $row->ssgId;
                    $settingNewFormat[$index]["ssgDateStart"]           = $row->ssgDateStart;
                    $settingNewFormat[$index]["ssgDateEnd"]             = $row->ssgDateEnd;

                    $settingNewFormat[$index]["StandardPoint"]          = 0;
                    $settingNewFormat[$index]["pointToMoneyLevel-S"]    = 0;
                    $settingNewFormat[$index]["pointToMoneyLevel-L"]    = 0;
                    $settingNewFormat[$index]["Reward"]                 = 0;
                    $settingNewFormat[$index]["moneyToPoint"]           = 0;
                    $settingNewFormat[$index]["Refer"]                  = 0;
                    $settingNewFormat[$index]["PreOrder"]               = 0;
                    $settingNewFormat[$index]["Tax"]                    = 0;
                    $settingNewFormat[$index]["M-Fee"]                  = 0;
                    $settingNewFormat[$index]["L-Fee"]                  = 0;
                }

                switch($row->sscName){

                    case "pointToMoneyLevel-S" :   $settingNewFormat[$index]["pointToMoneyLevel-S"]    = $row->sscValue; 
                                                    break;
                    case "pointToMoneyLevel-L" :   $settingNewFormat[$index]["pointToMoneyLevel-L"]    = $row->sscValue; 
                                                    break;
                    case "Reward"              :   $settingNewFormat[$index]["Reward"]                 = $row->sscValue;
                                                    break;
                    case "moneyToPoint"        :   $settingNewFormat[$index]["moneyToPoint"]           = $row->sscValue;
                                                    break;
                    case "Refer"               :   $settingNewFormat[$index]["Refer"]                  = $row->sscValue;
                                                    break;
                    case "PreOrder"            :   $settingNewFormat[$index]["PreOrder"]               = $row->sscValue;
                                                    break;
                    case "Tax"                 :   $settingNewFormat[$index]["Tax"]                    = $row->sscValue;
                                                    break;
                    case "M-Fee"               :   $settingNewFormat[$index]["M-Fee"]                  = $row->sscValue;
                                                    break;
                    case "L-Fee"               :   $settingNewFormat[$index]["L-Fee"]                  = $row->sscValue;
                                                    break;
                    case "StandardPoint"       :   $settingNewFormat[$index]["StandardPoint"]          = $row->sscValue;
                                                    break;
                }

            }

            return $settingNewFormat;
        }

        public function getSettingScheduleById(){

            $ssgId = $this->input->post("ssgId");
            $result = $this->M_Setting->getSettingScheduleById($ssgId);
            $result = $result->result();

            $json = array();
            $json["status"] = 200;
            $json["msg"] = "success";

            $json["response"]["settingScheduleGroup"]["ssgId"]           = $result[0]->ssgId;
            $json["response"]["settingScheduleGroup"]["ssgDateStart"]    = $result[0]->ssgDateStart;
            $json["response"]["settingScheduleGroup"]["ssgDateEnd"]      = $result[0]->ssgDateEnd;
            $json["response"]["settingScheduleGroup"]["settingSchedule"] = array();

            $tempArr = array();
            foreach($result as $settingSchedule){
               
                $tempArr["sscId"]    = $settingSchedule->sscId;
                $tempArr["sscName"]  = $settingSchedule->sscName;
                $tempArr["sscValue"] = $settingSchedule->sscValue;
                array_push($json["response"]["settingScheduleGroup"]["settingSchedule"], $tempArr); 
            }

            echo json_encode($json);
        }


        public function updateSettingSchedule(){

            $ssgId       = $this->input->post("ssgId");
            $ssgDateStart   = $this->input->post("ssgDateStart");
            $ssgDateEnd     = $this->input->post("ssgDateEnd");
            $shceduleList   = $this->input->post("scheduleList");

            $result = $this->M_Setting->updateSettingSchedule($ssgId, $ssgDateStart, $ssgDateEnd, $shceduleList);
            
            $json["status"]     = 200;
            $json["msg"]        = "success";
            $json["response"]   = "";

            echo json_encode($json);
        }

        public function deleteSettingSchedule(){

            $ssgId = $this->input->post("ssgId");
            $this->M_Setting->deleteSettingSchedule($ssgId);
            
            $json["status"]     = 200;
            $json["msg"]        = "success";
            $json["response"]   = "";

            echo json_encode($json);
        }
    }
?>
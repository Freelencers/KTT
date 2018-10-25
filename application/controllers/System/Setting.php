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
            $allPageNumber =  $this->M_Setting->getSettingRows("HISTORY") / $limitPage;

            // Repare Response
            $json["status"] = 200;
            $json["msg"] = "Success";
            $json["response"]["pagination"] = genPagination($currentPage, $allPageNumber);
            $json["response"]["dataList"] = $this->convertFormat($setting);

            echo json_encode($json);
        }

        public function getSettingScheduleList(){

            // Parameter
            $currentPage    = $this->input->post("currentPage");
            $limitPage      = $this->input->post("limitPage");
            $search         = $this->input->post("search");

            // get data list 
            $setting = $this->M_Setting->getSettingScheduleList($currentPage, $limitPage, $search);
            $setting = $setting->result();

            // get page number
            $allPageNumber =  round($this->M_Setting->getSettingRows("SCHEDULE") / $limitPage);

            // Repare Response
            $json["status"] = 200;
            $json["msg"] = "Success";
            $json["response"]["pagination"] = genPagination($currentPage, $allPageNumber);
            $json["response"]["dataList"] = $this->convertFormat($setting);

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
                    $settingNewFormat[$index]["ssgId"]                 = $row->ssgId;
                    $settingNewFormat[$index]["dateStart"]             = $row->ssgDateStart;
                    $settingNewFormat[$index]["dateEnd"]               = $row->ssgDateEnd;

                    $settingNewFormat[$index]["standardPoint"]         = 0;
                    $settingNewFormat[$index]["pointToMoneyLevelS"]    = 0;
                    $settingNewFormat[$index]["pointToMoneyLevelL"]    = 0;
                    $settingNewFormat[$index]["commission"]            = 0;
                    $settingNewFormat[$index]["moneyToPoint"]          = 0;
                    $settingNewFormat[$index]["refer"]                 = 0;
                    $settingNewFormat[$index]["pounderWeight"]         = 0;
                    $settingNewFormat[$index]["tax"]                   = 0;
                    $settingNewFormat[$index]["sFee"]                  = 0;
                    $settingNewFormat[$index]["lFee"]                  = 0;
                }

                switch($row->sscName){

                    case "pointToMoneyLevelS" :   $settingNewFormat[$index]["pointToMoneyLevelS"]    = $row->sscValue; 
                                                    break;
                    case "pointToMoneyLevelL" :   $settingNewFormat[$index]["pointToMoneyLevelL"]    = $row->sscValue; 
                                                    break;
                    case "commission"          :   $settingNewFormat[$index]["commission"]             = $row->sscValue;
                                                    break;
                    case "moneyToPoint"        :   $settingNewFormat[$index]["moneyToPoint"]          = $row->sscValue;
                                                    break;
                    case "refer"               :   $settingNewFormat[$index]["refer"]                 = $row->sscValue;
                                                    break;
                    case "pounderWeight"       :   $settingNewFormat[$index]["pounderWeight"]         = $row->sscValue;
                                                    break;
                    case "tax"                 :   $settingNewFormat[$index]["tax"]                   = $row->sscValue;
                                                    break;
                    case "sFee"               :   $settingNewFormat[$index]["sFee"]                  = $row->sscValue;
                                                    break;
                    case "lFee"               :   $settingNewFormat[$index]["lFee"]                  = $row->sscValue;
                                                    break;
                    case "standardPoint"       :   $settingNewFormat[$index]["standardPoint"]         = $row->sscValue;
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
            $sscList   = $this->input->post("sscList");

            $result = $this->M_Setting->updateSettingSchedule($ssgId, $ssgDateStart, $ssgDateEnd, $sscList);
            
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

        public function createSettingSchedule(){

            $ssgDateStart   = $this->input->post("ssgDateStart");
            $ssgDateEnd     = $this->input->post("ssgDateEnd");
            $sscList        = $this->input->post("sscList");

            $result = $this->M_Setting->createSettingSchedule($ssgDateStart, $ssgDateEnd, $sscList);

            if($result){

                $json["status"]     = 200;
                $json["msg"]        = "sucess";
                $json["response"]   = "";
            }else{

                $json["status"]     = 200;
                $json["msg"]        = "Insert fails";
                $json["response"]   = "";
            }

            echo json_encode($json);
        }

        public function updateSettingDefault(){

            $ssgDateStart   = date("Y-m-d H:i:s");
            $ssgDateEnd     = null;
            $sedList        = $this->input->post("sedList");

            $result = $this->M_Setting->updateSettingDefault($ssgDateStart, $ssgDateEnd, $sedList);

            if($result){

                $json["status"]     = 200;
                $json["msg"]        = "sucess";
                $json["response"]   = "";
            }else{

                $json["status"]     = 200;
                $json["msg"]        = "Insert fails";
                $json["response"]   = "";
            }

            echo json_encode($json);
        }
    }
?>
<?php 
class M_Setting extends CI_Model {

   public function getSetting(){

        $this->db->select("*")
        ->from("settingDefault");

        return $this->db->get();
   } 

   public function getSettingHistory($currentPage, $limitPage, $search){

        $limitPage      = $limitPage * 10;

        $this->db->select("sscId, ssgCreatedate, sscValue, sscName, ssgId, DATE(ssgDateStart) as ssgDateStart, DATE(ssgDateEnd) as ssgDateEnd")
        ->from("settingScheduleGroup")
        ->join("settingSchedule", "sscSsgId = ssgId");

        // search 
        if($search){ 

            $this->db->group_start();
            $this->db->like('ssgCreatedate', $search);
            $this->db->or_like('sscValue', $search);
            $this->db->or_like('sscName', $search);
            $this->db->or_like('ssgCreatedate', $search);
            $this->db->group_end();
        }

        // limit page
        if($currentPage > 1){

            $start = ($currentPage - 1) * $limitPage + 1;
        }else{
        
            $start = 1;
        }

        $this->db->order_by("ssgId", "DESC")
        ->limit($limitPage, $start);

        return $this->db->get();
   }

   public function getSettingHistoryPageNumber(){

        $this->db->select("sscId")
        ->from("settingSchedule");

        return $this->db->get()->num_rows();
   }

   public function getSettingScheduleList($currentPage, $limitPage, $search){

        $limitPage = 10 * $limitPage;

        $this->db->select("sscId, ssgCreatedate, sscValue, sscName, ssgId, DATE(ssgDateStart) as ssgDateStart, DATE(ssgDateEnd) as ssgDateEnd")
        ->from("settingScheduleGroup")
        ->join("settingSchedule", "sscSsgId = ssgId", "inner");

        // search 
        if($search){ 

            $this->db->group_start();
            $this->db->like('ssgCreatedate', $search);
            $this->db->or_like('sscValue', $search);
            $this->db->or_like('sscName', $search);
            $this->db->or_like('ssgCreatedate', $search);
            $this->db->group_end();
        }

        // limit page
        if($currentPage > 1){

            $start = ($currentPage - 1) * $limitPage + 1;
        }else{
        
            $start = 1;
        }

        $this->db->where('ssgDateEnd IS NOT NULL', null, false)
        ->order_by("ssgId", "DESC")
        ->limit($limitPage, $start);

        return $this->db->get();
   }

   public function getSettingScheduleById($ssgId){

        $this->db->select("ssgId, ssgDateStart, ssgDateEnd, sscId, sscName, sscValue")
        ->from("settingScheduleGroup")
        ->join("settingSchedule", "ssgId = sscSsgId", "inner")
        ->where("ssgId", $ssgId);

        return $this->db->get();
   }

   public function updateSettingSchedule($ssgId, $ssgDateStart, $ssgDateEnd, $shceduleList){

        // Update at settingShceduleGroup
        $settingScheduleGroupData["ssgDateStart"]   = $ssgDateStart;
        $settingScheduleGroupData["ssgDateEnd"]     = $ssgDateEnd;

        $this->db->where("ssgId", $ssgId)
        ->update("settingScheduleGroup", $settingScheduleGroupData);

        // Update settingSchedule
        $settingScheduleList = json_decode($shceduleList, true);
        $this->db->update_batch('settingSchedule',$settingScheduleList, 'sscId');

        return true;
   }

   public function deleteSettingSchedule($ssgId){

        $updateList["ssgDeletedate"] = date("Y-m-d");
        $updateList["ssgDeleteBy"]   = $this->session->userdata("accId");
        $result = $this->db->where("ssgId", $ssgId)
        ->update("settingScheduleGroup", $updateList);

        return $result;
   }

   public function createSettingSchedule($ssgDateStart, $ssgDateEnd, $sscList){

        $this->db->trans_start();

        // create group of schedule
        $ssgData["ssgDateStart"] = $ssgDateStart;
        $ssgData["ssgDateEnd"]   = $ssgDateEnd;
        $ssgData["ssgCreatedate"]= date("Y-m-d H:i:s");
        $ssgData["ssgCreateBy"]  = $this->session->userdata("accId");
        $this->db->insert("settingScheduleGroup", $ssgData);

        // create setting shcedule list
        $ssgId   = $this->db->insert_id();
        $sscList = json_decode($sscList, true);

        // add ssgId
        for($i=0;$i<count($sscList);$i++){

            $sscList[$i]["sscSsgId"] = $ssgId;
        }

        $this->db->insert_batch("settingSchedule", $sscList);

        $this->db->trans_complete();

        return $this->db->trans_status();
   }

   public function updateSettingDefault($ssgDateStart, $ssgDateEnd, $sedList){

        // Update default
        $sedListJson = json_decode($sedList, true);
        $this->db->trans_start();
        $this->db->update_batch("settingDefault", $sedListJson, "sedId");
        $this->db->trans_complete();

        // create group and save
        $sscList = str_replace("sed", "ssc", $sedList);
        $sscListJson = json_decode($sscList, true);

        // Remove sscId
        for($i=0;$i<count($sscListJson);$i++){

            unset($sscListJson[$i]["sscId"]);
        }

        // Convert json to string
        $sscListString = json_encode($sscListJson);
        $result = $this->createSettingSchedule($ssgDateStart, $ssgDateEnd, $sscListString);

        return $this->db->trans_status() && $result;
   }
}
?>
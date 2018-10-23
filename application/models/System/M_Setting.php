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
}
?>
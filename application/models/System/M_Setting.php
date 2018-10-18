<?php 
class M_Setting extends CI_Model {

   public function getSetting(){

        $this->db->select("*")
        ->from("settingDefault");

        return $this->db->get();
   } 

   public function getSettingHistory($currentPage, $limitPage, $search){

        $currentPage    = $currentPage * 10;
        $limitPage      = $currentPage * 10;

        $this->db->select("sscId, ssgCreatedate, sscValue, sscName, ssgId, ssgDateStart, ssgDateEnd")
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

        $this->db->order_by("ssgCreatedate", "DESC")
        ->limit($limitPage, $start);

        return $this->db->get();
   }

   public function getSettingHistoryPageNumber(){

        $this->db->select("sscId")
        ->from("settingSchedule");

        return $this->db->get()->num_rows();
   }

   public function getSettingScheduleList($currentPage, $limitPage, $search){
        $currentPage    = $currentPage * 10;
        $limitPage      = $currentPage * 10;

        $this->db->select("sscId, ssgCreatedate, sscValue, sscName, ssgId, ssgDateStart, ssgDateEnd")
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

        $this->db->where('ssgDateEnd IS NOT NULL', null, false)
        ->order_by("ssgCreatedate", "DESC")
        ->limit($limitPage, $start);

        return $this->db->get();
   }

   public function convertScheduleDataFormat(){

    // get Group id
    $this->db->select("ssgId")
    ->from("settingScheduleGroup");

    // push field to group
   }
}
?>
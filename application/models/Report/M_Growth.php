<?php 
class M_Growth extends CI_Model {
   
    public function getGrowthCurrentYear(){

        $result = $this->db->select("cusCode, cusFullName, SUM(epnAmount) AS epnAmount, MONTH(epnCreatedate) AS month")
        ->from("expense")
        ->join("customer", "cusId = epnCusId", "inner")
        ->where("YEAR(epnCreatedate)", date("Y"))
        ->group_by("cusCode")
        ->group_by("MONTH(epnCreatedate)")
        ->group_by("YEAR(epnCreatedate)")
        ->order_by("cusCode", "ASC");

        return $this->db->get();
    }

    public function getGrowthLastYear(){

        $result = $this->db->select("cusCode, SUM(epnAmount) AS epnAmount")
        ->from("expense")
        ->join("customer", "cusId = epnCusId", "inner")
        ->where("YEAR(epnCreatedate)", date("Y") - 1)
        ->where("MONTH(epnCreatedate)", 12)
        ->group_by("cusCode")
        ->group_by("MONTH(epnCreatedate)")
        ->group_by("YEAR(epnCreatedate)")
        ->order_by("cusCode", "ASC");

        return $this->db->get();
    }
}
?>
<?php 
class M_Growth extends CI_Model {
   
    public function getGrowthCurrentYear(){

        $result = $this->db->select("cusCode, cusFullName, SUM(epnAmount) AS epnAmount, MONTH(epnCreatedate) AS month")
        ->from("expense")
        ->join("customer", "cusId = epnCusId", "inner")
        ->where("YEAR(epnCreatedate)", date("Y"))
        ->group_by("cusCOde")
        ->group_by("MONTH(epnCreatedate)")
        ->group_by("YEAR(epnCreatedate)")
        ->order_by("cusCode", "ASC");

        return $this->db->get();
    }
}
?>
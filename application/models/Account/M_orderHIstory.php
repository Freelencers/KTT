<?php
class M_orderHistory extends CI_Model {

    public function getOrderHistory($currentPage,$limitPage,$search,$orlimit){

        $result = $this->db->select("DATE(ordCreatedate) as ordCreatedate, ordCode, cusFullName, ordTotal, ordStatus, ordId")
        ->from("order")
        ->join("customer", "cusId = ordCusId", "inner");

        if($search){ 

            $this->db->group_start();
            $this->db->like('cusCode', $search);
            $this->db->or_like('cusFullName', $search);
            $this->db->group_end();
        }

        if($orlimit == "LIMIT"){

            $offset = ($currentPage-1) * $limitPage;
            $this->db->order_by("ordId", "DESC")
            ->limit($limitPage, $offset);
        }

        return $this->db->get();
    }
}
?>
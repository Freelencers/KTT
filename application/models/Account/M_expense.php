<?php
class M_expense extends CI_Model {

   public function getExpenseListAndAmount(){

        $expenseAmount = $this->db->select("SUM(epnAmount) AS expenseAmount, DATE(epnCreatedate) as epnCreatedate")
        ->from("expense")
        ->where("DATE(epnCreatedate)", date("Y-m-d"))
        ->where("epnType", "EXPENSE")
        ->get()
        ->row();

        $incomeAmount = $this->db->select("SUM(epnAmount) AS incomeAmount, DATE(epnCreatedate) as epnCreatedate")
        ->from("expense")
        ->where("DATE(epnCreatedate)", date("Y-m-d"))
        ->where("epnType", "INCOME")
        ->get()
        ->row();

        //echo json_encode($incomeAmount);

        if($expenseAmount->expenseAmount == null){
            
            $json["amount"]["expense"] = 0;
        }else{

            $json["amount"]["expense"] = $expenseAmount->expenseAmount;
        }

        if($incomeAmount->incomeAmount == null){

            $json["amount"]["income"] = 0;
        }else{

            $json["amount"]["income"] = $incomeAmount->incomeAmount;
        }
        return $json;
   } 

   public function getExpenseList($currentPage,$limitPage,$search, $startDate, $endDate, $type, $orlimit){

        $result = $this->db->select("epnId, epnType, epnTitle, epnDetail, epnAmount, DATE(epnCreatedate) as epnCreatedate")
        ->from("expense");
        
        

        if($search){ 

            //echo "SEARCH";
            $this->db->group_start();
            $this->db->like('epnTitle', $search);
            $this->db->or_like('epnDetail', $search);
            $this->db->group_end();
        }

        if($startDate != "" && $endDate != ""){ 
            
            //echo "DATE";
            $this->db->group_start();
            $this->db->or_where('DATE(epnCreatedate) > ', $startDate);
            $this->db->where('DATE(epnCreatedate) < ', $endDate);
            $this->db->group_end();
        }

        if($type != "BOTH"){ 
            //echo "TYPE";
            $this->db->group_start();
            $this->db->or_where('epnType', $type);
            $this->db->group_end();
        }

        if($orlimit == "LIMIT"){

            $offset = ($currentPage-1) * $limitPage;
            $this->db->order_by("epnId", "DESC")
            ->limit($limitPage, $offset);
        }

        return $this->db->get();
    }

    public function getExpenseDetail($epnId){

        $result = $this->db->select("epnId, epnType, epnTitle, epnDetail, epnAmount, DATE(epnCreatedate) as epnCreatedate")
        ->from("expense")
        ->where("epnId", $epnId);

        return $this->db->get();
    }

    public function deleteExpense($epnId){

        $this->db->where("epnId", $epnId)
        ->delete("expense");

        return $this->db->affected_rows();
    }

    public function createExpense($input){

        $input["epnCreatedate"] = date("Y-m-d H:i:s");

        $this->db->insert("expense", $input);
        return $this->db->affected_rows();
    }

    public function updateExpense($input, $epnId){

        $this->db->where("epnId", $epnId)
        ->update("expense", $input);

        return $this->db->affected_rows();
    }
}
?>
<?php 
class M_Benefit extends CI_Model {
   
   
    public function getProfitUsedCostByProduct($includeWaitPay, $year){

        //lang load
		$languaue = $this->session->userdata("languaue");
        $this->lang->load('ktt', $languaue);
        
        // get income from expense
        $this->db->select("SUM(ordCost) AS cost, SUM(ordTotal) AS income, SUM(ordTotal - ordCost) AS profit, MONTH(ordCreatedate) as month")
        ->from("order")
        ->where("YEAR(ordCreatedate)", $year) 
        ->where("ordStatus", "SUCCESS");

        if($includeWaitPay == "true"){

            $this->db->or_where("ordStatus", "WAIT-PAY");
        }

        $this->db->group_by("MONTH(ordCreatedate)");
        $result = $this->db->get()->result();

        // convert format
        $benefitList = array();
        $benefitList[0]["name"] = $this->lang->line("reportBenefitIncome");
        $benefitList[0]["data"] = array();

        $benefitList[1]["name"] = $this->lang->line("reportBenefitExpense");
        $benefitList[1]["data"] = array();

        $benefitList[2]["name"] = $this->lang->line("reportBenefitProfit");
        $benefitList[2]["data"] = array();

        for($i=0;$i<12;$i++){

            $benefitList[0]["data"][$i] = 0;
            $benefitList[1]["data"][$i] = 0;
            $benefitList[2]["data"][$i] = 0;
            for($j=0;$j<count($result);$j++){

                if($result[$j]->month == ($i + 1)){

                    $benefitList[0]["data"][$i] = (int)$result[$j]->income;
                    $benefitList[1]["data"][$i] = (int)$result[$j]->cost;
                    $benefitList[2]["data"][$i] = (int)$result[$j]->profit;
                }
            }
        }

        return $benefitList;
    }

    public function getProfitUsedCostByExpense($year){

        //lang load
		$languaue = $this->session->userdata("languaue");
        $this->lang->load('ktt', $languaue);
        
        $income = $this->db->select("SUM(epnAmount) AS income, MONTH(epnCreatedate) as month")
        ->from("expense")
        ->where("YEAR(epnCreatedate)", $year) 

        ->group_start()
        ->where("epnSection", "ORDER")
        ->or_where("epnSection", "UPGRADE-CUSTOMER")
        ->group_end()

        ->group_by("MONTH(epnCreatedate)")
        ->get()
        ->result();
        

        $outcome = $this->db->select("SUM(epnAmount) AS outcome, MONTH(epnCreatedate) as month")
        ->from("expense")
        ->where("epnSection != 'ORDER'")
        ->where("YEAR(epnCreatedate)", $year) 
        ->where("epnSection != 'UPGRADE-CUSTOMER'")
        ->group_by("MONTH(epnCreatedate)")
        ->get()
        ->result();

        

        // convert format income
        $benefitList = array();
        $benefitList[0]["name"] = $this->lang->line("reportBenefitIncome");
        $benefitList[0]["data"] = array();
        for($i=0;$i<12;$i++){

            $benefitList[0]["data"][$i] = 0;
            for($j=0;$j<count($income);$j++){

                if($income[$j]->month == ($i + 1)){

                    $benefitList[0]["data"][$i] = (int)$income[$j]->income;
                }
            }

        }

        // convert format income
        $benefitList[1]["name"] = $this->lang->line("reportBenefitExpense");
        $benefitList[1]["data"] = array();

        $benefitList[2]["name"] = $this->lang->line("reportBenefitProfit");
        $benefitList[2]["data"] = array();

        for($i=0;$i<12;$i++){

            $benefitList[1]["data"][$i] = 0;
            for($j=0;$j<count($outcome);$j++){

                if($outcome[$j]->month == ($i + 1)){

                    $benefitList[1]["data"][$i] = (int)$outcome[$j]->outcome;
                }
            }
            $benefitList[2]["data"][$i] = $benefitList[0]["data"][$i] - $benefitList[1]["data"][$i]; 

        }

        return $benefitList;
    }
}
?>
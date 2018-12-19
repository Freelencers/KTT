<?php
    class Benefit extends CI_controller
    {
       
        public function getBenefit(){

            $costByProduct = $this->input->post("costByProduct");
            $costByExpense = $this->input->post("costByExpense");
            $includeWaitPay = $this->input->post("includeWaitPay");
            $year = $this->input->post("year");

            $this->load->model("Report/M_Benefit");
            if($costByProduct == "true"){

                $result = $this->M_Benefit->getProfitUsedCostByProduct($includeWaitPay, $year);
                $result["mode"] = "product";
                echo json_encode($result);
            }else if($costByExpense == "true"){

                $result = $this->M_Benefit->getProfitUsedCostByExpense($year);
                $result["mode"] = "expense";
                echo json_encode($result);
            }
        }
    }
?>
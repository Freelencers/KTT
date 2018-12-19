<?php
    class Growth extends CI_controller
    {
       
        public function getGrowthList(){


            $this->load->model("Report/M_growth");
            $result = $this->M_growth->getGrowthCurrentYear()->result();

            // convert data format
            $dataHashTable = array();
            for($i=0;$i<count($result);$i++){

                $dataHashTable[$result[$i]->cusCode]["fullName"] = $result[$i]->cusFullName;
                $dataHashTable[$result[$i]->cusCode]["code"] = $result[$i]->cusCode;
                $dataHashTable[$result[$i]->cusCode]["incomeOfMonth"][$result[$i]->month] = $result[$i]->epnAmount;
            }

            $json["response"]["dataList"] = $dataHashTable;
            echo json_encode($json);
        }
    }
?>
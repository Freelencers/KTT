<?php
    class Growth extends CI_controller
    {
       
        public function getGrowthList(){


            // $data["data"][0] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
            // $data["data"][1] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
            // $data["data"][2] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
            // $data["data"][3] = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];

            // echo json_encode($data);
            // die;

            $this->load->model("Report/M_growth");
            $result = $this->M_growth->getGrowthCurrentYear()->result();
            $lastYearRawData = $this->M_growth->getGrowthLastYear()->result();


            // convert format
            for($i=0;$i<count($result);$i++){

                $dataHashTable[$result[$i]->cusCode]["code"] = $result[$i]->cusCode;
                $dataHashTable[$result[$i]->cusCode]["fullName"] = $result[$i]->cusFullName;
                if($i == 0){

                    $dataHashTable[$result[$i]->cusCode]["incomeOfMonth"][$result[$i]->month] = $result[$i]->epnAmount;
                }else{

                    $dataHashTable[$result[$i]->cusCode]["incomeOfMonth"][$result[$i]->month] = $result[$i]->epnAmount;
                }
            }

            // convert format last year
            $lastYear = array();
            for($i=0;$i<count($lastYearRawData);$i++){

                $index = $lastYearRawData[$i]->cusCode;
                $lastYear[$index] = $lastYearRawData[$i]->epnAmount;
            }


            // assign value of empty index array 
            foreach($dataHashTable as $customer){

                for($j=1;$j<=12;$j++){

                    if(!array_key_exists($j, $customer["incomeOfMonth"])){

                        $dataHashTable[$customer["code"]]["incomeOfMonth"][$j] = 0;
                    }
                }
            }

            // calculate percentage
            foreach($dataHashTable as $customer){

                $index = $customer["code"];
                for($i=1;$i<=12;$i++){

                    if($customer["incomeOfMonth"][$i] != 0){
                    
                        if($i == 1){

                            if(!array_key_exists($ndex, $lastYear)){

                                $lastYearAmount = 0;
                            }else{

                                $lastYearAmount = $lastYear[$index];
                            }
                            $dataHashTable[$index]["incomeOfMonth"][$i] = (($customer["incomeOfMonth"][$i] - $lastYearAmount) * 100) / $customer["incomeOfMonth"][$i];
                            $dataHashTable[$index]["incomeOfMonthRaw"][$i] = $customer["incomeOfMonth"][$i];
                        }else{

                            $dataHashTable[$index]["incomeOfMonth"][$i] = (($customer["incomeOfMonth"][$i] - $customer["incomeOfMonth"][$i - 1]) * 100) / $customer["incomeOfMonth"][$i];
                            $dataHashTable[$index]["incomeOfMonthRaw"][$i] = $customer["incomeOfMonth"][$i];
                        }
                    }
                }
            }

            // format for data table
            $dataTable["data"] = array();
            $temp = array();
            foreach($dataHashTable as $cusCode => $detail){

                $temp[0]    = $cusCode;
                $temp[1]    = $detail["fullName"];
                $temp[14]   = 0;
                $index      = 2;
                for($i=1;$i<=12;$i++){

                    $temp[$index++]  = $detail["incomeOfMonth"][$i];
                    $temp[14]       += $detail["incomeOfMonth"][$i];
                }

                $temp[14] = round($temp[14] / 12, 2);
                array_push($dataTable["data"], $temp);
            }

            //$json["response"]["dataList"] = $dataHashTable;
            echo json_encode($dataTable);
        }
    }
?>
<?php
class M_order extends CI_Model {

    public function getProductList($currentPage,$limitPage,$search,$orlimit){

        $result = $this->db->select("matCode, matName, prdId, prdPoint, prdFullPrice, prdDiscount, SUM(stoVirtualStock) AS stoVirtualStock, untName")
        ->from("product")
        ->join("material",'matId = prdMatId', "inner")
        ->join("stock", "stoMatId = matId AND stoLast = 1", "inner")
        ->join("unit", "untId = matUntId", "inner")
        ->where("prdDeleteBy IS NULL");

        if($search){ 

            $this->db->group_start();
            $this->db->like('matName', $search);
            $this->db->or_like('matCode', $search);
            $this->db->group_end();
        }

        if($orlimit == "LIMIT"){

            $offset = ($currentPage-1) * $limitPage;
            $this->db->order_by("prdId", "DESC")
            ->limit($limitPage, $offset);
        }

        $this->db->group_by("matId");

        return $this->db->get();
    }

    public function getMyOrderList($ordId,$currentPage,$limitPage,$search,$mode){

        $this->db->select("sodId, prdId, matCode , matName , prdPoint, prdFullPrice, prdDiscount, untName, sodQty")
        ->from("order")
        ->join("subOrder"   , "ordId = sodOrdId", "inner")
        ->join("product"    , "sodPrdId = prdId", "inner")
        ->join("material"   , "prdMatId = matId", "inner")
        ->join("unit"       , "matUntId = untId", "inner")
        ->where("ordId", $ordId);

        if($search){ 

            $this->db->group_start();
            $this->db->like('matName', $search);
            $this->db->group_end();
        }

        if($mode == "LIMIT"){

            $offset = ($currentPage-1)*$limitPage;
            $this->db->order_by("ordId", "DESC")
            ->limit($limitPage, $offset);    
        }

        return $this->db->get();
    }

    public function addToCart($sodOrdId, $sodPrdId, $sodQty, $action){

        // Preapare data
        $subOrderList["sodOrdId"]   = $sodOrdId;
        $subOrderList["sodQty"]     = $sodQty;
        $subOrderList["sodPrdId"]   = $sodPrdId;

        $this->db->trans_start();

        // get suborder
        $subOrder = $this->db->select("sodId, sodPrdId, sodQty")
        ->from("subOrder")
        ->where("sodOrdId", $sodOrdId)
        ->where("sodPrdId", $sodPrdId)
        ->get()
        ->row();

        // check have already
        if($subOrder == null){

            // create new row
            $this->db->insert("subOrder", $subOrderList);
        }else{

            if($action == "ADD"){

                // Add
                $subOrderList["sodQty"]     = $subOrder->sodQty + $sodQty;
            }else{

                // Remove
                $subOrderList["sodQty"]     = $subOrder->sodQty - $sodQty;
            }

            // update qty
            $this->db->where("sodId", $subOrder->sodId)
            ->update("subOrder", $subOrderList);
        }

        $this->db->trans_complete();
        return $this->db->trans_status();
    }
   
    public function getOrderList($currentPage,$limitPage,$search, $mode){

        $this->load->model("Fanshine/M_customer");
        $settingValue = $this->M_general->getSettingValue();

        $result = $this->db->select("ordId, ordCode, cusFullName, ordStatus, ordTotal, DATE(ordCreatedate) AS ordCreatedate")
        ->from("order")
        ->join("customer", "cusId = ordCusId", "inner")
        ->where("ordStatus !=", "SUCCESS");

        if($search){ 

            $this->db->group_start();
            $this->db->like('matName', $search);
            $this->db->group_end();
        }

        if($mode == "LIMIT"){

            $offset = ($currentPage-1)*$limitPage;
            $orderList = $this->db->order_by("ordId", "DESC")
            ->limit($limitPage, $offset)
            ->get();    
        
            // clear old order
            $this->db->trans_start();

            $orderDel = $this->db->select("ordId, ordCreatedate")
            ->from("order")
            ->having("DATEDIFF(NOW(), ordCreatedate) > 3")
            ->where("ordStatus", "SHOPPING")
            ->or_where("ordStatus", "WAIT-PAY")
            ->get()
            ->result();

            // Copy array
            if(count($orderDel) > 0){

                $ordIdList = array();
                for($i=0;$i<count($orderDel);$i++){
        
                    array_push($ordIdList, $orderDel[$i]->ordId);
                }

                $this->db->where_in("ordId", $ordIdList)
                ->delete("order");

                $this->db->where_in("sodOrdId", $ordIdList)
                ->delete("subOrder");
            }

            // checkout from stock
            $this->load->model("Wherehouse/M_stock");

            $stockList = $this->db->select("matId, sodQty, ordCreatedate, COUNT(DISTINCT sodId), ordId, ordCusId")
                        ->from("order")
                        ->join("subOrder", "ordId = sodOrdId", "inner")
                        ->join("product", "prdId = sodPrdId", "inner")
                        ->join("material", "matId = prdMatId", "inner")
                        ->where("ordStatus", "SHIPPED")
                        ->having("DATEDIFF(NOW(), ordCreatedate) > 1")
                        ->get()
                        ->result();

            $orderWillUpdateToSuccess = array();

            for($i=0;$i<count($stockList);$i++){

                // update stock
                $totalCostOfproduct = $this->M_stock->outputStock($stockList[$i]->matId, "AUTO-MODE", $stockList[$i]->sodQty, "SYSTEM", "ACTUAL");

                // check case new customer and order more than condition 
                $prdId = 1; // special item for new customer
                $isNewCustomer = $this->M_customer->isNewCustomer($stockList[$i]->ordCusId);
                if($isNewCustomer == 1){

                    // get current level
                    $cusLevel = $this->db->select("cusLevel")
                                ->from("customer")
                                ->where("cusId", $stockList[$i]->ordCusId)
                                ->get()
                                ->row();

                    // check give reward already
                    $giveReward = $this->db->select("cmsId")
                                    ->from("commission")
                                    ->where("cmsCusId", $stockList[$i]->ordCusId)
                                    ->like("cmsDetail", "Level : " . $cusLevel->cusLevel, "before")
                                    ->get()
                                    ->num_rows();
                    if($giveReward == 0){

                        $isOrderMoreThanCondition = $this->db->select("sodId, SUM(sodQty) AS sodQty")
                                                    ->from("subOrder")
                                                    ->where("sodPrdId", $prdId)
                                                    ->having("sodQty >= " . $settingValue[0]["pounderWeight"])
                                                    ->get()
                                                    ->num_rows();
                        if($isOrderMoreThanCondition == 1){
                            $rewardCommission["cmsDetail"]            = "สมาชิกใหม่สั่งซื้อสินค้า ได้ตามเป้าที่กำหนด " . $settingValue[0]["pounderWeight"] . " กิโล";
                            $rewardCommission["cmsTotalPublicPoint"]  = 0;
                            $rewardCommission["cmsTotalPrivatePoint"] = 0; 
                            $rewardCommission["cmsTotalPoint"]        = 0;
                            $rewardCommission["cmsTotalCommission"]   = $settingValue[0]["commission"];
                            $rewardCommission["cmsCreatedate"]        = date("Y-m-d");
                            $rewardCommission["cmsCusId"]             = $stockList[$i]->ordCusId;
                            $this->db->insert("commission", $rewardCommission);                            
                        }
                    }
                }

                // pepare data for update success
                $orderWillUpdateToSuccess[$i]["ordStatus"] = "SUCCESS";
                $orderWillUpdateToSuccess[$i]["ordCost"]   = $totalCostOfproduct;
                $orderWillUpdateToSuccess[$i]["ordId"]     = $stockList[$i]->ordId;
            }

            // create expense and commisison of success order
            $orderShipped = $this->db->select("ordTotal, ordCode, ordCusId, ordCreatedate, cusLevel, cusCode")
                            ->from("order")
                            ->join("customer", "cusId = ordCusId", "inner")
                            ->where("ordStatus", "SHIPPED")
                            ->having("DATEDIFF(NOW(), ordCreatedate) > 1")
                            ->get()
                            ->result();

            $expenseList        = array();
            $commissionList     = array();
            $temp               = array();
            $orderSuccessIdList = array();

            for($i=0;$i<count($orderShipped);$i++){

                $expenseList[$i]["epnTitle"]        = "รายการสั่งซื้อ";
                $expenseList[$i]["epnAmount"]       = $orderShipped[$i]->ordTotal; 
                $expenseList[$i]["epnType"]         = "INCOME";
                $expenseList[$i]["epnSection"]      = "ORDER";
                $expenseList[$i]["epnDetail"]       = "รหัส : " . $orderShipped[$i]->ordCode;
                $expenseList[$i]["epnCusId"]        = $orderShipped[$i]->ordCusId;
                $expenseList[$i]["epnCreatedate"]   = date("Y-m-d H:i:s");

                // this list for head not include owner
                $headerList = $this->M_customer->getHeaderIdOfthisChain($orderShipped[$i]->ordCusId);
                for($j=0;$j<count($headerList);$j++){

                    // create for header
                    $temp["cmsDetail"]            = "รหัส : " . $orderShipped[$i]->ordCode .", จาก : " . $orderShipped[$i]->cusCode;
                    $temp["cmsTotalPublicPoint"]  = $orderShipped[$i]->ordTotal * $settingValue[0]["moneyToPoint"];
                    $temp["cmsTotalPrivatePoint"] = 0; 
                    $temp["cmsTotalPoint"]        = $temp["cmsTotalPublicPoint"];
                    $temp["cmsTotalCommission"]   = $temp["cmsTotalPoint"] * $settingValue[0]["pointToMoneyLevel" . $orderShipped[$i]->cusLevel];
                    $temp["cmsCreatedate"]        = date("Y-m-d");
                    $temp["cmsCusId"]             = $headerList[$j]; 
                    array_push($commissionList, $temp);
                }

                //create for owner order
                $temp["cmsDetail"]            = "รหัส : " . $orderShipped[$i]->ordCode .", จาก : " . $orderShipped[$i]->cusCode;
                $temp["cmsTotalPublicPoint"]  = 0;
                $temp["cmsTotalPrivatePoint"] = $orderShipped[$i]->ordTotal * $settingValue[0]["moneyToPoint"];
                $temp["cmsTotalPoint"]        = $temp["cmsTotalPrivatePoint"];
                $temp["cmsTotalCommission"]   = $temp["cmsTotalPoint"] * $settingValue[0]["pointToMoneyLevel" . $orderShipped[$i]->cusLevel];
                $temp["cmsCreatedate"]        = date("Y-m-d");
                $temp["cmsCusId"]             = $orderShipped[$i]->ordCusId;

                // separate insert for fix bug
                $this->db->insert("commission", $temp);
            }

            if(count($orderShipped)){

                // create expense transaction
                $this->db->insert_batch("expense", $expenseList);

                // create commission transaction
                $this->db->insert_batch("commission", $commissionList);
            }

            // success order shipped
            if(count($orderWillUpdateToSuccess) >= 1){

                $this->db->update_batch("order", $orderWillUpdateToSuccess, "ordId");
            }

            $this->db->trans_complete();
        }else{

            $orderList = $this->db->get();
        }

        return $orderList;
    }

    public function getInvoiceDetail($ordId){

        $orderDetail =  $this->db->select("ordId, ordSubTotal, ordShipping, ordTax, ordTotal, ordCode, DATE(ordCreatedate) AS ordCreatedate, ordCusId, cusFullName, cusCode, bacNumber, bacBranch, bacName, bacType, banName")
                            ->from("order")
                            ->join("customer", "cusId = ordCusId", "inner")
                            ->join("bankAccount", "bacCusId = cusId", "inner")
                            ->join("bank", "banId = bacBanId", "inner")
                            ->where("ordId", $ordId)
                            ->get()
                            ->row();

        $addressDetail = $this->db->select("addDetail, addPostcode, prvName, disName, addType")
                            ->from("address")
                            ->join("province"   , "prvId = addProvince", "inner")
                            ->join("district"   , "disId = addDistrict", "inner")
                            ->where("addCusId", $this->session->userdata("ordCusId"))
                            ->where("addType", "DELIVERY")
                            ->get()
                            ->row();

        $contactDetail = $this->db->select("conName, conValue")
                            ->from("contact")
                            ->where("conCusId" , $this->session->userdata("ordCusId"))
                            ->get()
                            ->result();

        $subOrderDetail = $this->db->select("sodQty, matName, untName,(prdPoint * sodQty) as prdPoint, ((prdFullPrice - prdDiscount) * sodQty) AS prdPrice")
                            ->from("subOrder")
                            ->join("product"    , "sodPrdId = prdId", "inner")
                            ->join("material"   , "prdMatId = matId", "inner")
                            ->join("unit"   , "untId = matUntId", "inner")
                            ->where("sodOrdId", $ordId)
                            ->get()
                            ->result();

        $json["OrderDetail"] = $orderDetail;
        $json["addressDetail"] = $addressDetail;
        $json["contactDetail"] = $contactDetail;
        $json["subOrderDetail"] = $subOrderDetail;

        return $json;
    }

    public function deleteOrder($ordId){

        $this->db->trans_start();

        $this->db->where("ordId", $ordId)
        ->delete("order");

        $this->db->where("sodOrdId", $ordId)
        ->delete("subOrder");

        $this->db->trans_complete();

        return $this->db->trans_status();
        
    }

    public function removeFromCart($sodId){
        
        $this->db->trans_start();

        $this->db->where("sodId", $sodId)
        ->delete("suborder");

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function updateOrderStatus($ordId){
        
        $this->db->trans_start();

        $seleteOrdStatus = $this->db->select("ordStatus")
                            ->from("order")
                            ->where("ordId",$ordId)
                            ->get()
                            ->row();

        $ordStatusArr["ordStatus"] = "" ; 

        switch($seleteOrdStatus->ordStatus){
            case "WAIT-PAY":
                     $ordStatusArr["ordStatus"] = "PAYED";
                     $this->db->where("ordId", $ordId)
                     ->update("order", $ordStatusArr);
                    break;
            case "PAYED":
                     $ordStatusArr["ordStatus"] = "SHIPPING";
                     $this->db->where("ordId", $ordId)
                     ->update("order", $ordStatusArr);
                    break;        
            case "SHIPPING":
                      $ordStatusArr["ordStatus"] = "SHIPPED";
                      $this->db->where("ordId", $ordId)
                     ->update("order", $ordStatusArr);
                    break;
            case "SHIPPED":
                      $ordStatusArr["ordStatus"] = "WAIT-PAY";
                      $this->db->where("ordId", $ordId)
                      ->update("order", $ordStatusArr);
                    break;
        }

        $this->db->trans_complete();

        return $this->db->trans_status();

    }      

    public function createOrder(){

        $order["ordStatus"]     = "SHOPPING";
        $order["ordSubTotal"]   = 0;
        $order["ordShipping"]   = 0;
        $order["ordTax"]        = 0;
        $order["ordTotal"]      = 0;
        $order["ordCreatedate"] = date("Y-m-d");

        $this->db->trans_start();

        $lastCode = $this->db->select("MAX(ordCode) AS ordCode")
        ->from("order")
        ->where("YEAR(ordCreatedate)", date("Y"))
        ->get()
        ->row();

        if($lastCode->ordCode == ""){

            $order["ordCode"] = "ORD" . date("Ymd") . "00001";
        }else{

            $countNumber      = intval(substr($lastCode->ordCode, -5)) + 1;
            $order["ordCode"] = "ORD" . date("Ymd").str_pad($countNumber, 5, "0", STR_PAD_LEFT);
        }

        $this->db->insert("order", $order);

        // Generate Order Code
        $lastId = $this->db->insert_id();


        // define session
        $this->session->set_userdata("ordId", $lastId);

        // delete old Order
        $this->db->where("ordCreatedate !=", date("Y-m-d"))
        ->where("ordStatus", "SHOPPING")
        ->delete("order");

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function complete($orderDetail){

        $this->db->where("ordId", $this->session->userdata("ordId"))
        ->update("order", $orderDetail);

    }


    public function checkout($ordCusId){

        $ordId = $this->session->userdata("ordId");
        $orderDetail["ordCusId"] = $ordCusId;

        // update customer owener for this order
        $this->db->where("ordId", $ordId)
        ->update("order", $orderDetail);

        return $this->db->affected_rows();
    }


    public function searchInArray($array, $value){

        for($i=0;$i<count($array);$i++){

            echo $value . " = ". $array[$i]."<BR>";
            if($value == $array[$i]){

                return "HAVE";
            }
        }
        return "NOT-HAVE";
    }
}
?>
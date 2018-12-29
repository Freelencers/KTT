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

        // #####################
        // clear old order
        // #####################

            $orderDel = $this->db->select("ordId, ordCreatedate")
            ->from("order")
            ->having("DATEDIFF(NOW(), ordCreatedate) > 3")
            ->where("ordStatus", "SHOPPING")
            ->or_where("ordStatus", "WAIT-PAY")
            ->get()
            ->result();

            // Copy array
            if(count($orderDel) > 0){

                for($i=0;$i<count($orderDel);$i++){
        
                    $this->deleteOrder($orderDel[$i]->ordId);
                
                }
            }

        // #####################
        // update to success
        // #####################

            $stockList = $this->db->select("ordCreatedate, ordId, ordCusId, ordCode")
            ->from("order")
            ->where("ordStatus", "SHIPPED")
            ->having("DATEDIFF(NOW(), ordCreatedate) > 1")
            ->get()
            ->result();

            $orderWillUpdateToSuccess = array();

            for($i=0;$i<count($stockList);$i++){

                // pepare data for update success
                $orderWillUpdateToSuccess[$i]["ordStatus"] = "SUCCESS";
                $orderWillUpdateToSuccess[$i]["ordId"]     = $stockList[$i]->ordId;
            }

            // success order shipped
            if(count($orderWillUpdateToSuccess) > 0){

                $this->db->update_batch("order", $orderWillUpdateToSuccess, "ordId");
            }


        // #####################
        // Get order list
        // #####################
        $result = $this->db->select("ordId, ordCode, cusFullName, ordStatus, ordTotal, DATE(ordCreatedate) AS ordCreatedate, ordPayAlready")
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
        }else{

            $orderList = $this->db->get();
        }

        return $orderList;
    }

    public function checkPayAlready($ordId){

        $this->load->model("Fanshine/M_customer");
        $settingValue = $this->M_general->getSettingValue();

        $this->db->trans_start();

        // ################################################
        // create expense and commisison of success order
        // ################################################

            $orderShipped = $this->db->select("ordTotal, ordCode, ordCusId, ordCreatedate, cusLevel, cusCode, ordId, ordTotalPoint")
            ->from("order")
            ->join("customer", "cusId = ordCusId", "inner")
            ->where("ordId", $ordId)
            ->get()
            ->row();

            $expenseList        = array();
            $commissionList     = array();
            $temp               = array();
            $orderSuccessIdList = array();

            $expenseList["epnTitle"]        = "รายการสั่งซื้อ";
            $expenseList["epnAmount"]       = $orderShipped->ordTotal; 
            $expenseList["epnType"]         = "INCOME";
            $expenseList["epnSection"]      = "ORDER";
            $expenseList["epnDetail"]       = "รหัส : " . $orderShipped->ordCode;
            $expenseList["epnCusId"]        = $orderShipped->ordCusId;
            $expenseList["epnCreatedate"]   = date("Y-m-d H:i:s");

            // create expense transaction
            $this->db->insert("expense", $expenseList);

            // this list for head not include owner
            $headerList = $this->M_customer->getHeaderIdOfthisChain($orderShipped->ordCusId);

            for($j=0;$j<count($headerList);$j++){

                // create for header
                $temp["cmsDetail"]            = "รหัส : " . $orderShipped->ordCode .", จาก : " . $orderShipped->cusCode;
                //$temp["cmsTotalPublicPoint"]  = $orderShipped->ordTotalPoint * $settingValue[0]["moneyToPoint"];
                $temp["cmsTotalPublicPoint"]  = $orderShipped->ordTotalPoint;
                $temp["cmsTotalPrivatePoint"] = 0; 
                $temp["cmsTotalPoint"]        = $temp["cmsTotalPublicPoint"];
                $temp["cmsTotalCommission"]   = $temp["cmsTotalPoint"] * $settingValue[0]["pointToMoneyLevel" . $orderShipped->cusLevel];
                $temp["cmsCreatedate"]        = date("Y-m-d");
                $temp["cmsCusId"]             = $headerList[$j]; 
                array_push($commissionList, $temp);
            }

            //create for owner order
            $temp["cmsDetail"]            = "รหัส : " . $orderShipped->ordCode .", จาก : " . $orderShipped->cusCode;
            $temp["cmsTotalPublicPoint"]  = 0;
            //$temp["cmsTotalPrivatePoint"] = $orderShipped->ordTotalPoint * $settingValue[0]["moneyToPoint"];
            $temp["cmsTotalPrivatePoint"] = $orderShipped->ordTotalPoint;
            $temp["cmsTotalPoint"]        = $temp["cmsTotalPrivatePoint"];
            $temp["cmsTotalCommission"]   = $temp["cmsTotalPoint"] * $settingValue[0]["pointToMoneyLevel" . $orderShipped->cusLevel];
            $temp["cmsCreatedate"]        = date("Y-m-d");
            $temp["cmsCusId"]             = $orderShipped->ordCusId;

            // separate insert for fix bug
            $this->db->insert("commission", $temp);



            if(count($commissionList) > 0){

                // create commission transaction
                $this->db->insert_batch("commission", $commissionList);
            }

        // #######################
        // Condition of fanshine
        // #######################

        // check case new customer and order more than condition 
        $prdId = 1; // special item for new customer
        

        // get current level
        $cusLevel = $this->db->select("cusLevel")
                    ->from("customer")
                    ->where("cusId", $orderShipped->ordCusId)
                    ->get()
                    ->row();

        // check give reward already
        $giveReward = $this->db->select("cmsId")
                        ->from("commission")
                        ->where("cmsCusId", $orderShipped->ordCusId)
                        ->where("cmsDetail", "สมาชิกใหม่ Level : " . $cusLevel->cusLevel . " สั่งซื้อสินค้า ได้ตามเป้าที่กำหนด " . $settingValue[0]["pounderWeight"] . " กิโล")
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

                $rewardCommission["cmsDetail"]            = "สมาชิกใหม่ Level : " . $cusLevel->cusLevel . " สั่งซื้อสินค้า ได้ตามเป้าที่กำหนด " . $settingValue[0]["pounderWeight"] . " กิโล";
                $rewardCommission["cmsTotalPublicPoint"]  = 0;
                $rewardCommission["cmsTotalPrivatePoint"] = 0; 
                $rewardCommission["cmsTotalPoint"]        = 0;
                $rewardCommission["cmsTotalCommission"]   = $settingValue[0]["commission"];
                $rewardCommission["cmsCreatedate"]        = date("Y-m-d");
                $rewardCommission["cmsCusId"]             = $stockList[$i]->ordCusId;
                $this->db->insert("commission", $rewardCommission);                            
            }
        }

        // #########################################
        // checkout from stock & special reward
        // #########################################
        $this->load->model("Wherehouse/M_stock");

        $stockList = $this->db->select("matId, sodQty, ordCreatedate, ordId, ordCusId, ordCode")
                    ->from("order")
                    ->join("subOrder", "ordId = sodOrdId", "inner")
                    ->join("product", "prdId = sodPrdId", "inner")
                    ->join("material", "matId = prdMatId", "inner")
                    ->where("ordId", $ordId)
                    ->group_by("sodId")
                    ->get()
                    ->result();

        for($i=0;$i<count($stockList);$i++){

            // update stock
            $totalCostOfproduct += $this->M_stock->outputStock($stockList[$i]->matId, "AUTO-MODE", $stockList[$i]->sodQty, "ORDER : " . $stockList[$i]->ordCode, "ACTUAL");
        }

        // update status in order pay already
        $order["ordPayAlready"] = 1;
        //$order["ordCost"] = $totalCostOfproduct;

        $this->db->where("ordId", $ordId)
        ->update("order", $order);

        $this->db->trans_complete();

        return $this->db->trans_status();
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
                            ->where("addCusId", $orderDetail->ordCusId)
                            ->where("addType", "DELIVERY")
                            ->get()
                            ->row();

        $contactDetail = $this->db->select("conName, conValue")
                            ->from("contact")
                            ->where("conCusId" , $orderDetail->ordCusId)
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

        //#####################
        // return virtual stock 
        //#####################

        $this->load->model("Wherehouse/M_stock");
        // get order code
        $order = $this->db->select("ordCode")
                ->from("order")
                ->where("ordId", $ordId)
                ->get()
                ->row();

        // get stock 
        $stock = $this->db->select("stoId")
                    ->from("stock")
                    ->like("stoReason", $order->ordCode)
                    ->get()
                    ->result();

        for($i=0;$i<count($stock);$i++){

            $stockHistory = $this->db->select("shtStoId, shtFromLot, shtAmount, stoCost, stoLocId, stoMatId, stoExpDate")
                            ->from("stockHistory")
                            ->join("stock", "shtFromLot = stoId")
                            ->where("shtStoId < ", $stock[$i]->stoId)
                            ->order_by("shtStoId", "DESC")
                            ->limit(1)
                            ->get()
                            ->row();

            $this->M_stock->inputStock($stockHistory->stoMatId, $stockHistory->stoCost, $stockHistory->shtAmount, $stockHistory->stoLocId, $stockHistory->stoExpDate, "RETURN : " . $order->ordCode, "VIRTUAL");
        }


        // remove transaction
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
        ->delete("subOrder");

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
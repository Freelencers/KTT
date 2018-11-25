<?php
class M_order extends CI_Model {

    public function getProductList($currentPage,$limitPage,$search,$orlimit){

        $result = $this->db->select("matCode, matName, prdId, prdPoint, prdFullPrice, prdDiscount, stoVirtualStock, untName")
        ->from("product")
        ->join("material",'matId = prdMatId', "inner")
        ->join("stock", "stoMatId = prdMatId AND stoLast = 1")
        ->join("unit", "untId = matUntId", "inner")
        ->where("matDeleteBy IS NULL");

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

        $result = $this->db->select("ordId, ordCode, cusFullName, ordStatus, ordTotal, DATE(ordCreatedate) AS ordCreatedate")
        ->from("order")
        ->join("customer", "cusId = ordCusId", "inner")
        ->where("ordStatus !=", "SUCCESS");
        //->join("subOrder", "sodOrdId = ordId", "inner")
        //->join("product", "prdId = sodPrdId", "inner");
    
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

        $orderList = $this->db->get();
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

        // success order shipped
        $success["ordStatus"] = "SUCCESS";
        $this->db->where("ordStatus", "SHIPPED")
        ->having("DATEDIFF(NOW(), ordCreatedate) > 1")
        ->update("order", $success);

        $this->db->trans_complete();

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

        $subOrderDetail = $this->db->select("sodQty, matName, (prdPoint * sodQty) as prdPoint, ((prdFullPrice - prdDiscount) * sodQty) AS prdPrice")
                            ->from("subOrder")
                            ->join("product"    , "sodPrdId = prdId", "inner")
                            ->join("material"   , "prdMatId = matId", "inner")
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


}
?>
<?php
class M_stock extends CI_Model {

  public function getStockList($currentPage, $limitPage, $search, $stockCondition){

    $accessMaterial = $this->session->userdata("accessMaterial");
    $accessProduct  = $this->session->userdata("accessProduct");

    $this->db->select("stoId, matId, stoMatId, matName, matType, matMin,SUM(stoActualStock) AS stoActualStock, SUM(stoVirtualStock) AS stoVirtualStock, matCode, locName")
    ->from("stock")
    ->join("location", "locId = stoLocId")
    ->join("material", "matId = stoMatId")
    ->where("matDeleteBy IS NULL")
    ->where("stoLast", 1);

    if($accessMaterial == 1 && $accessProduct == 0){

        //echo "ONLY MATERIAL";
        $this->db->where("matType", "MATERIAL");
    }

    if($accessProduct == 1 && $accessMaterial == 0){

        //echo "ONLY PRODUCT";
        $this->db->where("matType", "PRODUCT");
    }

    if($accessProduct == 1 && $accessMaterial == 1){

        //echo "SHOW ALL";
        $this->db->group_start();
        $this->db->where("matType", "PRODUCT");
        $this->db->or_where("matType", "MATERIAL");
        $this->db->group_end();
    }

    if($accessProduct == 0 && $accessMaterial == 0){

        //echo "NOT SHOW";
        $this->db->group_start();
        $this->db->where("matType", "NO-DISPLAY");
        $this->db->group_end();
    }

    if($search){ 

        $this->db->group_start();
        $this->db->like('matCode', $search);
        $this->db->or_like('matType', $search);
        $this->db->or_like('matName', $search);
        $this->db->group_end();
    }


    if(count($stockCondition)){

        $this->db->group_start();
        for($i=0;$i<count($stockCondition);$i++){

            switch($stockCondition[$i]){

                case "OUTOF-ACTUAL-STOCK" : $this->db->or_where("stoActualStock", 0);
                                        break;

                case "OUTOF-VIRTUAL-STOCK" : $this->db->or_where("stoVirtualStock", 0);
                                        break;

                case "REFILS-ACTUAL-STOCK" : $this->db->or_where("stoActualStock <= matMin AND stoActualStock != 0");
                                        break;

                case "REFILS-ACTUAL-STOCK" : $this->db->or_where("stoVirtualStock <= matMin AND stoVirtualStock != 0");
                                        break;
            }
        }
        $this->db->group_end();
    }

    if($limitPage != 0){

        $offset = ($currentPage-1) * $limitPage;
        $this->db->group_by("stoMatId")
        ->limit($limitPage, $offset)
        ->order_by("stoId");
    }

    return $this->db->get();
  }

  public function inputStock($matId, $matCost, $matAmount, $matLocId, $matExpDate, $stoReason){

    $this->db->trans_start();

    // get data from last history
    $lastInput = $this->db->select("stoId, stoMatId, stoActualStock, stoVirtualStock, stoLocId")
                ->from("stock")
                ->where("stoMatId", $matId)
                ->where("stoLocId", $matLocId)
                ->where("stoLast", 1)
                ->get()
                ->row();

    // create new transaction
    if($lastInput){

        // already history befor
        $stoList["stoMatId"]        = $lastInput->stoMatId;
        $stoList["stoLocId"]        = $lastInput->stoLocId;
        $stoList["stoAction"]       = "INPUT";
        $stoList["stoCost"]         = $matCost;
        $stoList["stoLast"]         = 1;
        $stoList["stoActualStock"]  = $lastInput->stoActualStock + $matAmount;
        $stoList["stoVirtualStock"] = $lastInput->stoVirtualStock + $matAmount;
        $stoList["stoAmount"]       = $matAmount;
        $stoList["stoCreatedate"]   = date("Y-m-d H:i:s");
        $stoList["stoExpDate"]      = $matExpDate;
        $stoList["stoCreateby"]     = $this->session->userdata("accId");
        $stoList["stoReason"]       = $stoReason;

        // update last transaction
        $stockData["stoLast"] = 0;
        $this->db->where("stoId", $lastInput->stoId)
        ->update("stock", $stockData);

    }else{

        // new item 
        $stoList["stoMatId"]        = $matId;
        $stoList["stoLocId"]        = $matLocId;
        $stoList["stoAction"]       = "INPUT";
        $stoList["stoCost"]         = $matCost;
        $stoList["stoLast"]         = 1;
        $stoList["stoActualStock"]  = $matAmount;
        $stoList["stoVirtualStock"] = $matAmount;
        $stoList["stoAmount"]       = $matAmount;
        $stoList["stoCreatedate"]   = date("Y-m-d H:i:s");
        $stoList["stoExpDate"]      = $matExpDate;
        $stoList["stoCreateby"]     = $this->session->userdata("accId");
        $stoList["stoReason"]       = $stoReason;
    }

    // insert new transaction
    $this->db->insert("stock", $stoList);

    // initial hash
    $history["shtStoId"]        = $this->db->insert_id();
    $history["shtType"]         = "INPUT";
    $history["shtAmount"]       = $matAmount;
    $history["shtTotal"]        = $matAmount * $matCost;
    $history["shtActionDate"]   = date("Y-m-d H:i:s");

    // insert history tranasction
    $this->db->insert("stockHistory", $history);

    $this->db->trans_complete();

    return $this->db->trans_status();
  }

  public function outputStock($matId, $matLocId, $matAmount, $stoReason, $stockType = "BOTH"){


    // transaction
    $this->db->trans_start();

    // prepare array for history !! separate easy to search
    $stoId      = array();
    $history    = array();
    $stoList    = array();
    $cost       = 0;

    // update used for lot expiration soon
    for($i=1;$i<=$matAmount;$i++){

        // get lot have soon expiration 
        $this->db->select("stoId, stoUsed, stoAmount, stoCost, stoMatId, stoLocId, stoActualStock, stoVirtualStock, stoLast")
        ->from("stock")
        ->where("stoMatId", $matId);

        if($matLocId != "AUTO-MODE"){

            $this->db->where("stoLocId", $matLocId);
        }

        $this->db->where("stoLast", 1)
        ->where("stoUsed != stoAmount")
        ->order_by("stoExpDate", "ASC")
        ->limit(1);

        $stoExpSoon = $this->db->get()->row();

        // update used for auto mode
        $inputTransaction = $this->db->select("stoId, stoUsed, stoCost")
        ->from("stock")
        ->where("stoMatId", $matId)
        ->where("stoAction", "INPUT")
        ->where("stoUsed != stoAmount")
        ->order_by("stoExpDate", "ASC")
        ->order_by("stoId", "ASC")
        ->limit(1)
        ->get()
        ->row();

        $stockData["stoUsed"]  = $inputTransaction->stoUsed + 1;
        $cost                 += $inputTransaction->stoCost;
        $this->db->where("stoId", $inputTransaction->stoId)
        ->update("stock", $stockData);

        // #################
        // History save
        // #################

        // find duplicate stoId
        if(array_search( $stoExpSoon->stoId, $stoId) !== FALSE){

            // update Amount and Total Cost 
            $history[$stoExpSoon->stoId]["shtAmount"]       += 1;
            $history[$stoExpSoon->stoId]["shtTotal"]        += $stoExpSoon->stoCost;

            // update last stock
            switch($stockType){

                case "BOTH" :   $stoList[$stoExpSoon->stoId]["stoActualStock"]  -= 1;
                                $stoList[$stoExpSoon->stoId]["stoVirtualStock"] -= 1;
                                //echo "BOTH";
                                break;

                case "ACTUAL" : $stoList[$stoExpSoon->stoId]["stoActualStock"]  -= 1;
                                //echo "ACTUAL";
                                break;

                case "VIRTUAL" : $stoList[$stoExpSoon->stoId]["stoVirtualStock"] -= 1;
                                 //echo "VIRTUAL";
                                 break;
            }
            $stoList[$stoExpSoon->stoId]["stoAmount"]       += 1;

        }else{

            // push to re-check
            array_push($stoId, $stoExpSoon->stoId);

            // initial hash
            $history[$stoExpSoon->stoId] = array();
            $history[$stoExpSoon->stoId]["shtStoId"]        = $stoExpSoon->stoId;
            $history[$stoExpSoon->stoId]["shtType"]         = "OUTPUT";
            $history[$stoExpSoon->stoId]["shtAmount"]       = 1;
            $history[$stoExpSoon->stoId]["shtTotal"]        = $stoExpSoon->stoCost;
            $history[$stoExpSoon->stoId]["shtActionDate"]   = date("Y-m-d H:i:s");

            // initial last stock
            $stoList[$stoExpSoon->stoId]["stoMatId"]        = $stoExpSoon->stoMatId;
            $stoList[$stoExpSoon->stoId]["stoLocId"]        = $stoExpSoon->stoLocId;
            $stoList[$stoExpSoon->stoId]["stoAction"]       = "OUTPUT";
            $stoList[$stoExpSoon->stoId]["stoLast"]         = 1;

            switch($stockType){

                case "BOTH" :   $stoList[$stoExpSoon->stoId]["stoActualStock"]  = $stoExpSoon->stoActualStock - 1;
                                $stoList[$stoExpSoon->stoId]["stoVirtualStock"] = $stoExpSoon->stoVirtualStock - 1;
                                break;

                case "ACTUAL" : $stoList[$stoExpSoon->stoId]["stoActualStock"]  = $stoExpSoon->stoActualStock - 1;
                                $stoList[$stoExpSoon->stoId]["stoVirtualStock"] = $stoExpSoon->stoVirtualStock;
                                break;

                case "VIRTUAL" : $stoList[$stoExpSoon->stoId]["stoActualStock"]  = $stoExpSoon->stoActualStock;
                                 $stoList[$stoExpSoon->stoId]["stoVirtualStock"] = $stoExpSoon->stoVirtualStock - 1;
                                 break;
            }
            $stoList[$stoExpSoon->stoId]["stoAmount"]       = 1;
            $stoList[$stoExpSoon->stoId]["stoCreatedate"]   = date("Y-m-d H:i:s");
            $stoList[$stoExpSoon->stoId]["stoCreateby"]     = $this->session->userdata("accId");
            $stoList[$stoExpSoon->stoId]["stoReason"]       = $stoReason;
        }
    }

    // Reset index
    $history = array_values($history);
    $stoList = array_values($stoList);

    // insert history tranasction
    $this->db->insert_batch("stockHistory", $history);

    // insert new transaction
    $this->db->insert_batch("stock", $stoList);

    // update last transaction to old status
    $stockData = "";
    $stockData["stoLast"] = 0;
    for($i=0;$i<count($stoId);$i++){

        $this->db->where("stoId", $stoId[$i])
        ->update("stock", $stockData);
    }

    $this->db->trans_complete();
    
    return $cost;
  }

  public function getStockHistoryList($currentPage, $limitPage, $search){

    $accessMaterial = $this->session->userdata("accessMaterial");
    $accessProduct  = $this->session->userdata("accessProduct");

    $this->db->select(" matCode, matName, stoCost, shtTotal, shtActionDate, matType, locName, shtAmount, shtType, stoReason")
    ->from("stockHistory")
    ->join("stock", "stoId = shtStoId", "inner")
    ->join("location", "locId = stoLocId", "inner")
    ->join("material", "matId = stoMatId", "inner");

    if($accessMaterial == 1 && $accessProduct == 0){

        //echo "ONLY MATERIAL";
        $this->db->where("matType", "MATERIAL");
    }

    if($accessProduct == 1 && $accessMaterial == 0){

        //echo "ONLY PRODUCT";
        $this->db->where("matType", "PRODUCT");
    }

    if($accessProduct == 1 && $accessMaterial == 1){

        //echo "SHOW ALL";
        $this->db->group_start();
        $this->db->where("matType", "PRODUCT");
        $this->db->or_where("matType", "MATERIAL");
        $this->db->group_end();
    }

    if($accessProduct == 0 && $accessMaterial == 0){

        //echo "NOT SHOW";
        $this->db->group_start();
        $this->db->where("matType", "NO-DISPLAY");
        $this->db->group_end();
    }

    if($search){ 

        $this->db->group_start();
        $this->db->like('matCode', $search);
        $this->db->or_like('matType', $search);
        $this->db->or_like('locName', $search);
        $this->db->group_end();
    }

    if($limitPage != 0){

        $offset = ($currentPage-1) * $limitPage;
        $this->db->limit($limitPage, $offset)
        ->order_by("shtActionDate", "DESC");
    }

    return $this->db->get();
  }

  public function getProductStockDetail($matId, $locationMode){

    $rawData = $this->db->select("stoId, matId, matName, matCode, locId, locName, stoVirtualStock, untName")
                ->from("stock")
                ->join("material", "matId = stoMatId", "inner")
                ->join("unit", "matUntId = untId", "inner")
                ->join("location", "locId = stoLocId", "inner")
                ->where("stoMatId", $matId)
                ->where("stoLast", 1)
                ->get()
                ->result();

    $dataRow["matId"]   = $rawData[0]->matId;
    $dataRow["matName"] = $rawData[0]->matName;
    $dataRow["matCode"] = $rawData[0]->matCode;
    $dataRow["matLocationList"] = array(); 


    if($locationMode == "ALL"){

        $locationList = $this->db->select("locId, locName")
                        ->from("location")
                        ->where("locDeleteBy IS NULL")
                        ->order_by("locName", "ASC")
                        ->get()
                        ->result();

        // show only location in stock
        for($i=0;$i<count($locationList);$i++){

            $matLocationList["locId"]   = $locationList[$i]->locId;
            $matLocationList["locName"] = $locationList[$i]->locName;
            array_push($dataRow["matLocationList"], $matLocationList);
        }

    }else{
            
        // show only location in stock
        for($i=0;$i<count($rawData);$i++){

            $matLocationList["locId"]   = $rawData[$i]->locId;
            $matLocationList["locName"] = $rawData[$i]->locName;
            $matLocationList["stoVirtualStock"] = $rawData[$i]->stoVirtualStock;
            $matLocationList["untName"] = $rawData[$i]->untName;
            array_push($dataRow["matLocationList"], $matLocationList);
        }
    }

   
    return $dataRow;
  }

  public function getLastCost($matId){

    $this->db->select("stoCost")
    ->from("stock")
    ->where("stoMatId", $matId)
    ->where("stoAction", "INPUT")
    ->order_by("stoId", "DESC")
    ->limit(1);

    return $this->db->get();
  }

  public function updateStockCompleteOrder(){

      // checkout from stock
      $orderList = $this->db->select("matId, sodQty")
      ->from("order")
      ->join("subOrder", "ordId = sodOrdId", "inner")
      ->join("product", "prdId = sodPrdId", "inner")
      ->join("material", "matId = prdMatId", "inner")
      ->where("ordId", $this->session->userdata("ordId"))
      ->get()
      ->result();

      for($i=0;$i<count($orderList);$i++){

          $this->outputStock($orderList[$i]->matId, "AUTO-MODE", $orderList[$i]->sodQty, "SYSTEM", "VIRTUAL");
      }
  }
}

?>
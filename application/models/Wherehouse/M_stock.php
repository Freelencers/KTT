 <?php
class M_stock extends CI_Model {

  public function getStockList($currentPage, $limitPage, $search, $stockCondition){

    $this->db->select("stoId, matId, stoMatId, matName, matType, matMin,SUM(stoActualStock) AS stoActualStock, SUM(stoVirtualStock) AS stoVirtualStock, matCode, locName")
    ->from("stock")
    ->join("location", "locId = stoLocId")
    ->join("material", "matId = stoMatId")
    ->where("stoLast", 1);

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

  public function inputStock($matId, $matCost, $matAmount, $matLocId, $matExpDate){

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

  public function outputStock($matId, $matLocId, $matAmount){

    if($matLocId != "AUTO-MODE"){

        // #####################
        // Manual Location
        // #####################

        // get last history
        $lastInput = $this->db->select("stoId, stoMatId, stoActualStock, stoVirtualStock, stoLocId, stoCost")
        ->from("stock")
        ->where("stoMatId", $matId)
        ->where("stoLocId", $matLocId)
        ->where("stoLast", 1)
        ->get()
        ->row();

    }else{

        // #####################
        // Auto Location
        // #####################

        // Find location and soon expire by matId
        $stoExpSoon = $this->db->select("stoId, stoUsed, stoAmount, stoMatId, stoLocId")
                        ->from("stock")
                        ->where("stoMatId", $matId)
                        ->where("stoAction", "INPUT")
                        ->having("stoUsed != stoAmount")
                        ->order_by("stoExpDate", "ASC")
                        ->limit(1)
                        ->get()
                        ->row();

        // find last transaction of expiration soon location
        $lastInput = $this->db->select("stoId, stoMatId, stoActualStock, stoVirtualStock, stoLocId, stoCost")
                        ->from("stock")
                        ->where("stoMatId", $stoExpSoon->stoMatId)
                        ->where("stoLocId", $stoExpSoon->stoLocId)
                        ->where("stoLast", 1)
                        ->get()
                        ->row();
    }

    // transaction
    $this->db->trans_start();

    // update last transaction to old status
    $stockData["stoLast"] = 0;
    $this->db->where("stoId", $lastInput->stoId)
    ->update("stock", $stockData);

    // prepare array for history !! separate easy to search
    $stoId      = array();
    $history    = array();
    $stoList  = array();

    // update used for lot expiration soon
    for($i=1;$i<=$matAmount;$i++){

        //echo $lastInput->stoMatId . " : " . $lastInput->stoLocId . "<BR>";

        // get lot have soon expiration 
        $this->db->select("stoId, stoUsed, stoAmount, stoCost, stoMatId, stoLocId, stoActualStock, stoVirtualStock")
        ->from("stock")
        ->where("stoMatId", $lastInput->stoMatId);

        if($matLocId != "AUTO-MODE"){

            $this->db->where("stoLocId", $lastInput->stoLocId);
        }

        $this->db->where("stoAction", "INPUT")
        ->having("stoUsed != stoAmount")
        ->order_by("stoExpDate", "ASC")
        ->limit(1);

        $stoExpSoon = $this->db->get()->row();


        // update used for auto mode
        $stockData["stoUsed"] = $stoExpSoon->stoUsed + 1;
        $this->db->where("stoId", $stoExpSoon->stoId)
        ->update("stock", $stockData);

        // #################
        // History save
        // #################

        // find duplicate stoId
        if(array_search( $stoExpSoon->stoId, $stoId) !== FALSE){

            // update Amount and Total Cost 
            $history[$stoExpSoon->stoId]["shtAmount"]       += 1;
            $history[$stoExpSoon->stoId]["shtTotal"]        += $stoExpSoon->stoCost;

            // update lasy stock
            $stoList[$stoExpSoon->stoId]["stoActualStock"]  = $stoExpSoon->stoActualStock - 1;
            $stoList[$stoExpSoon->stoId]["stoVirtualStock"] = $stoExpSoon->stoVirtualStock - 1;
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

            // update last stock
            $stoList[$stoExpSoon->stoId]["stoMatId"]        = $stoExpSoon->stoMatId;
            $stoList[$stoExpSoon->stoId]["stoLocId"]        = $stoExpSoon->stoLocId;
            $stoList[$stoExpSoon->stoId]["stoAction"]       = "OUTPUT";
            $stoList[$stoExpSoon->stoId]["stoLast"]         = 1;
            $stoList[$stoExpSoon->stoId]["stoActualStock"]  = $stoExpSoon->stoActualStock - 1;
            $stoList[$stoExpSoon->stoId]["stoVirtualStock"] = $stoExpSoon->stoVirtualStock - 1;
            $stoList[$stoExpSoon->stoId]["stoAmount"]       = 1;
            $stoList[$stoExpSoon->stoId]["stoCreatedate"]   = date("Y-m-d H:i:s");
            $stoList[$stoExpSoon->stoId]["stoCreateby"]     = $this->session->userdata("accId");
        }
    }

    // Reset index
    $history = array_values($history);
    $stoList = array_values($stoList);

    // insert history tranasction
    $this->db->insert_batch("stockHistory", $history);

    // insert new transaction
    $this->db->insert_batch("stock", $stoList);

    $this->db->trans_complete();
    
    return $this->db->trans_status();
  }

  public function getStockHistoryList($currentPage, $limitPage, $search){

    $this->db->select(" matCode, matName, stoCost, shtTotal, shtActionDate, matType, locName, shtAmount, shtType")
    ->from("stockHistory")
    ->join("stock", "stoId = shtStoId", "inner")
    ->join("location", "locId = stoLocId", "inner")
    ->join("material", "matId = stoMatId", "inner");

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
}
?>
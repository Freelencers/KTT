<?php
class M_customer extends CI_Model {

    public function createNewCustomer($customerDataJson){
        
        $dataListCustomer = array(
            "cusFanshineName"   => $customerDataJson["cusFanshineName"],
            "cusFullName"       => $customerDataJson["cusFullName"],
            "cusDateOfBirth"    => $customerDataJson["cusDateOfBirth"],
            "cusPassportId"     => $customerDataJson["cusPassportId"],
            "cusPersonalId"     => $customerDataJson["cusPersonalId"],
            "cusMarital"        => $customerDataJson["cusMarital"],
            "cusChild"          => $customerDataJson["cusChild"],
            "cusDescedant"      => $customerDataJson["cusDescedant"],
            "cusLevel"          => $customerDataJson["cusLevel"],
            "cusReferId"        => $customerDataJson["cusReferId"],
            "cusCouId"          => $customerDataJson["cusCouId"],
            "cusCreatedate"     => date('Y-m-d H:i:s'),
            "cusCreateBy"       => $this->session->userdata("accId")
        );   

        $this->db->trans_start();

        // Generate cusCode
        $lastCode = $this->db->select(" MAX(cusCode) AS cusCode")
        ->from("customer")
        ->where("YEAR(cusCreatedate)", date("Y"))
        ->where("cusDeleteBy IS NULL")
        ->get()
        ->row();

        // New year reset code
        if($lastCode->cusCode == ""){

            $dataListCustomer["cusCode"] = "KT" . date("Y") . date("m") . date("d") . "00001";
        }else{

            $countNumber      = intval(substr($lastCode->cusCode, -5)) + 1;
            $dataListCustomer["cusCode"] = "KT" . date("Y") . date("m") . date("d") .str_pad($countNumber, 5, "0", STR_PAD_LEFT);
        }

        $this->db->insert('customer', $dataListCustomer); 
        $cusId = $this->db->insert_id();

        for($i = 0;$i < count($customerDataJson["cusAddList"]);$i++){

            $customerDataJson["cusAddList"][$i]["addCusId"] = $cusId;
        }
        for($i = 0;$i < count($customerDataJson["cusContactList"]);$i++){

            $customerDataJson["cusContactList"][$i]["conCusId"] = $cusId;
        }
        for($i = 0;$i < count($customerDataJson["bankAccountDetail"]);$i++){

            $customerDataJson["bankAccountDetail"][$i]["bacCusId"] = $cusId;
        }
        $this->db->insert_batch('address', $customerDataJson["cusAddList"]); 
        $this->db->insert_batch('contact', $customerDataJson["cusContactList"]); 
        $this->db->insert_batch('bankAccount', $customerDataJson["bankAccountDetail"]);
        
        // update number of refTime for RefId
        $this->db->where("cusId", $dataListCustomer["cusReferId"])
        ->set('cusRefTime', '`cusRefTime` + 1', FALSE)
        ->update("customer");

        // Create levelup log
        $this->upgradeCustomerLevel($cusId, $dataListCustomer["cusLevel"]);

        // Create expense list 
        $this->load->model("Account/M_expense");
        $settingValue = $this->M_general->getSettingValue();

        $input["epnTitle"]  = "New Customer";
        $input["epnDetail"] = "CODE : " . $dataListCustomer["cusCode"] . " LV : " . $dataListCustomer["cusLevel"];
        $input["epnAmount"] = $settingValue[0][ strtolower($dataListCustomer["cusLevel"]) . "Fee"];
        $input["epnCusId"]  = $cusId;
        $input["epnType"]   = "INCOME";
        $input["epnSection"]= "NEW-CUSTOMER";
        $this->M_expense->createExpense($input);

        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function updateCustomerDetail($customerDataJson){

        $dataListCustomer = array(
            "cusFanshineName"   => $customerDataJson["cusFanshineName"],
            "cusFullName"       => $customerDataJson["cusFullName"],
            "cusDateOfBirth"    => $customerDataJson["cusDateOfBirth"],
            "cusPassportId"     => $customerDataJson["cusPassportId"],
            "cusPersonalId"     => $customerDataJson["cusPersonalId"],
            "cusMarital"        => $customerDataJson["cusMarital"],
            "cusChild"          => $customerDataJson["cusChild"],
            "cusDescedant"      => $customerDataJson["cusDescedant"],
            "cusLevel"          => $customerDataJson["cusLevel"],
            "cusReferId"        => $customerDataJson["cusReferId"],
            "cusCouId"          => $customerDataJson["cusCouId"],
            "cusUpdatedate"     => date('Y-m-d H:i:s'),
            "cusUpdateBy"       => $this->session->userdata("accId")
        );   

        $this->db->trans_start();

        $this->db->where("cusId", $customerDataJson["cusId"])
        ->update('customer', $dataListCustomer); 

        $this->db->update_batch('address', $customerDataJson["cusAddList"], "addId"); 
        $this->db->update_batch('contact', $customerDataJson["cusContactList"], "conId"); 
        $this->db->update_batch('bankAccount', $customerDataJson["bankAccountDetail"], "bacId"); 

        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    public function deleteCustomer($cusId){

        $customerData["cusDeleteBy"]    = $this->session->userdata("accId");
        $customerData["cusDeletedate"]  = date("Y-m-d");

        $this->db->where("cusId", $cusId)
        ->update("customer", $customerData);

        return $this->db->affected_rows();
    }

    public function getCustomerList($currentPage, $limitPage, $search){

        //$cusCode = "CONCAT('KT', LPAD(MONTH(cusCreatedate), 2, 0), LPAD(DAY(cusCreatedate), 2, 0), LPAD(cusId, 4, 0 )) AS cusCode";
        $this->db->select(" cusCode, cusId, cusFanshineName, cusFullName, cusLevel, DATE(cusCreatedate) AS cusCreatedate, DATEDIFF(NOW(),lvuDate) AS lvuDate, cusRefTime")
        ->from("customer")
        ->join("levelUp", "cusId = lvuCusId", "inner")
        ->where("cusDeleteBy IS NULL");

        // search 
        if($search){ 

            $this->db->group_start();
            $this->db->like('cusFanshineName ', $search);
            $this->db->or_like('cusFullName', $search);
            //$this->db->or_like('lvuDate', $search);
            $this->db->or_like('cusLevel', $search);
            //$this->db->or_like('cusCreatedate', $search);
            $this->db->or_like('cusCode', $search);
            $this->db->group_end();
        }

        // limit page
        if($currentPage > 1){

            $start = ($currentPage - 1) * $limitPage + 1;
        }else{
        
            $start = 0;
        }

        $this->db->order_by("cusId", "DESC")
        ->limit($limitPage, $start)
        ->group_by("cusId");

        return $this->db->get();
    }

    public function getCustomerAllRows(){

        $this->db->select("cusId")
        ->from("customer")
        ->where("cusDeleteBy IS NULL");

        return $this->db->get()->num_rows();
    }

    public function upgradeCustomerLevel($cusId, $cusLevel){

        $this->db->trans_start();

        // Insert data to levelUp
        $dataList = array();

        // get last level
        $lvuFrom                = $this->db->select("cusLevel, cusCode")
                                ->from("customer")
                                ->where("cusId", $cusId)
                                ->get()
                                ->row();
        
        $dataList["lvuCusId"]   = $cusId;
        $dataList["lvuFrom"]    = $lvuFrom->cusLevel;
        $dataList["lvuTo"]      = $cusLevel;
        $dataList["lvuDate"]    = date("Y-m-d H:i:s");
        $dataList["lvuPay"]     = $this->M_general->getSettingValue();

        // new user case
        if($dataList["lvuFrom"] == $cusLevel){

            $dataList["lvuFrom"]  = $cusLevel;
        }

        if($cusLevel == "S"){

            $dataList["lvuPay"] = $dataList["lvuPay"][0]["sFee"];
        }else{

            $dataList["lvuPay"] = $dataList["lvuPay"][0]["lFee"];
        }
        $this->db->insert("levelUp", $dataList);

        // Update detail in customer table
        $cusDetail = array();
        $cusDetail["cusLevel"] = $cusLevel;

        $this->db->where("cusId", $cusId)
        ->update("customer", $cusDetail);

        // ############################
        // create expense transaction
        // ############################

        // get setting value
        $this->load->model("Account/M_expense");
        $settingValue = $this->M_general->getSettingValue();

        // check up or down
        if(strcmp($dataList["lvuFrom"], $dataList["lvuTo"]) < 0){

            $input["epnTitle"]  = "Downgrade Customer";
            $input["epnAmount"] = $settingValue[0][ strtolower($dataList["lvuFrom"]) . "Fee"] - $settingValue[0][ strtolower($dataList["lvuTo"]) . "Fee"];
            $input["epnType"]   = "EXPENSE";
            $input["epnSection"]= "DOWNGRADE-CUSTOMER";
        }else{

            $input["epnTitle"]  = "Upgrade Customer";
            $input["epnAmount"] = $settingValue[0][ strtolower($dataList["lvuTo"]) . "Fee"] - $settingValue[0][ strtolower($dataList["lvuFrom"]) . "Fee"];
            $input["epnType"]   = "INCOME";
            $input["epnSection"]= "UPGRADE-CUSTOMER";
        }

        $input["epnDetail"] = "CODE : " . $lvuFrom->cusCode . " LV : " . $cusLevel;
        $input["epnCusId"]  = $cusId;
        $this->M_expense->createExpense($input);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function getCustomerDetailById($cusId){

        $response                       = $this->db->select("*")
                                        ->from("customer")
                                        ->where("cusId", $cusId)
                                        ->get()
                                        ->row_array();

        $response["cusAddList"]         =  $this->db->select("*")
                                        ->from("address")
                                        ->join("province"   , "prvId = addProvince", "inner")
                                        ->join("district"   , "disId = addDistrict", "inner")
                                        ->where("addCusId", $cusId)
                                        ->get()
                                        ->result();

        $response["cusContactList"]     = $this->db->select("*")
                                        ->from("contact")
                                        ->where("conCusId", $cusId)
                                        ->get()
                                        ->result();

        $response["bankAccountDetail"] = $this->db->select("*")
                                         ->from("bankAccount")
                                         ->where("bacCusId", $cusId)
                                         ->get()
                                         ->result();

        return $response;
    }

    public function getProvince(){

        $this->db->select("*")
        ->from("province");

        return $this->db->get();
    }

    public function getDistrict($prvId){

        $this->db->select("*")
        ->from("district")
        ->where("disPrvId", $prvId);

        return $this->db->get();
    }

    public function getCountry(){

        $this->db->select("*")
        ->from("country");

        return $this->db->get();
    }

    public function getBank(){

        $this->db->select("*")
        ->from("bank");

        return $this->db->get();
    }

    public function getRefer($search, $except){

        $cusCode = "CONCAT('KT', LPAD(MONTH(cusCreatedate), 2, 0), LPAD(DAY(cusCreatedate), 2, 0), LPAD(cusId, 4, 0 )) AS cusCode";
        $this->db->select($cusCode .", cusId, cusFanshineName, cusFullName, cusRefTime")
        ->from("customer")
        ->where("cusDeletedate IS NULL");

        if($except){

            $this->db->where("cusId !=", $except);
        }

        // search 
        if($search){ 

            $this->db->group_start();
            $this->db->like('cusFanshineName', $search);
            $this->db->or_having('cusCode', $search);
            $this->db->group_end();
        }

        return $this->db->get();
    }

    public function getHeaderIdOfthisChain($cusId){

        $allCustomerList = $this->db->select("cusId, cusReferId")
                            ->from("customer")
                            ->get()
                            ->result();

        $customerHashTable = array();
        for($i=0;$i<count($allCustomerList);$i++){

            $customerHashTable[$allCustomerList[$i]->cusId] = $allCustomerList[$i]->cusReferId;
        }

        // run backword in tree
        $chainOfCusId = array();
        while($customerHashTable[$cusId] != 0){
            
            $cusId = $customerHashTable[$cusId];
            array_push($chainOfCusId, $cusId);
        }

        return $chainOfCusId;
    }

    public function getLowerNumberOfThisId($cusId){

        $allCustomerList = $this->db->select("cusId, cusReferId")
                            ->from("customer")
                            ->get()
                            ->result();

        $customerHashTable = array();
        for($i=0;$i<count($allCustomerList);$i++){

            $customerHashTable[$allCustomerList[$i]->cusId] = $allCustomerList[$i]->cusReferId;
        }

        $counter = 0;
        $this->travelDownTree($cusId, $customerHashTable, $counter);

        return $counter;
    }

    public function travelDownTree($cusId, $customerHashTable, &$counter){

        foreach($customerHashTable as $index => $value){

            if($value == $cusId){

                $counter++;
                $this->travelDownTree($index, $customerHashTable, $counter);
            }
        }
    }

    public function isNewCustomer($cusId){

        $this->db->select("lvuDate")
        ->from("levelUp")
        ->where("lvuCusId", $cusId)
        ->having("DATEDIFF(NOW(), lvuDate) <= 60");

        return $this->db->get()->num_rows();
    }

}
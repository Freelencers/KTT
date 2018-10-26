<?php
class M_customer extends CI_Model {

    public function createNewCustomer($customerDataJson){
        
        $dataListCustomer = array(
            "cusFanshineName" => $customerDataJson["cusFanshineName"],
            "cusFullName" => $customerDataJson["cusFullName"],
            "cusDateOfBirth" => $customerDataJson["cusDateOfBirth"],
            "cusPassportId" => $customerDataJson["cusPassportId"],
            "cusPersonalId" => $customerDataJson["cusPersonalId"],
            "cusMarital" => $customerDataJson["cusMarital"],
            "cusChild" => $customerDataJson["cusChild"],
            "cusDescedant" => $customerDataJson["cusDescedant"],
            "cusLevel" => $customerDataJson["cusLevel"],
            "cusReferId" => $customerDataJson["cusReferId"],
            "cusCouId" => $customerDataJson["cusCouId"],
            "cusCreatedate" => date('Y-m-d H:i:s'),
            "cusCreateBy" => date('Y-m-d H:i:s')
        );   
        $this->db->insert('customer', $dataListCustomer); 
        $cusId = $this->db->select("MAX(cusId) as cusId")->from("customer")->get()->result();
        
        for($i = 0;$i < count($customerDataJson["cusAddList"]);$i++){
            $customerDataJson["cusAddList"][$i]["addCusId"] = $cusId[0]->cusId;
        }
        for($i = 0;$i < count($customerDataJson["cusContactList"]);$i++){
            $customerDataJson["cusContactList"][$i]["conCusId"] = $cusId[0]->cusId;
        }
        for($i = 0;$i < count($customerDataJson["bankAccountDetail"]);$i++){
            $customerDataJson["bankAccountDetail"][$i]["bacCusId"] = $cusId[0]->cusId;
        }
        $this->db->insert_batch('address', $customerDataJson["cusAddList"]); 
        $this->db->insert_batch('contact', $customerDataJson["cusContactList"]); 
        $this->db->insert_batch('bankaccount', $customerDataJson["bankAccountDetail"]); 
        
        return true;
    }

}
?>   
<?php
class M_customer extends CI_Model {

    public function deleteOrder($ordId){

        $this->db->trans_start();

        $this->db->where("ordId", $ordId)
        ->delete("order");

        $this->db->where("sodOrdId", $ordId)
        ->delete("suborder");

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

        $seleteOrdStatus = $this->db->select("ordStatus")->from("order")
                            ->where("ordId",$ordId)->get()->row();

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
    public function addToCart(){
        

    }
}

?>
    
    

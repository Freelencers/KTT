<?php
class Order extends CI_controller {  
    
    public function __construct()
        {
            parent::__construct();
            // Your own constructor code
            $this->load->model("Account/M_order");
        }
    public function deleteOrder($ordId){
        $ordId = $this->input->post("ordId");
        $resultData = $this->M_order->deleteOrder($ordId);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        }else{
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }

    }
    public function removeFromCart($sodId){
        $sodId = $this->input->post("sodId");
        $resultData = $this->M_order->removeFromCart($sodId);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        }else{
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
    }
    public function updateOrderStatus($ordId){
        $ordId = $this->input->post("ordId");
        $resultData = $this->M_order->updateOrderStatus($sodId);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        }else{
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
    }
    public function addToCart($sodQty,$sodOrdId,$sodPrdId){
        $sodQty = $this->input->post("sodQty");
        $sodOrdId = $this->input->post("sodOrdId");
        $sodPrdId = $this->input->post("sodPrdId");

        $resultData = $this->M_order->addToCart($sodQty,$sodOrdId,$sodPrdId);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        }else{
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }

    }  

}


?>
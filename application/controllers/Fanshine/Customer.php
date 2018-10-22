<?php
class Customer extends CI_controller {
    
    public function __construct()
    {
               parent::__construct();
               // Your own constructor code
               $this->load->model("Fanshine/M_customer");
    }
    public function createNewCustomer(){

        $customerData   = $this->input->post("CustomerData");
        $customerDataJson = json_decode($customerData, true);

        $resultData = $this->M_customer->createNewCustomer($customerDataJson);

        if($resultData) {
            $json['status'] = 200;
            $json['msg'] = "Success";
            echo json_encode($json);
        } else {
            $json['status'] = 200;
            $json['msg'] = "Error";
            echo json_encode($json);
        }
    }

}    

?>    
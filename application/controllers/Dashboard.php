<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct()
     {
                parent::__construct();
                // Your own constructor code
                $this->load->model("M_dashboard");
    }
	public function index()
	{
		
    }
    public function shippingCount()
    {
     
        //Call model
        $result = $this->M_dashboard->getShippingCount();
        $result = $result->num_rows();
        //$result = $result[0];

        //json fromat
        $json["status"]="";
        $json["msg"]="";
        $json["response"]["shippingCount"]= $result;

        echo json_encode($json);

    }
    public function payCount(){
        
        $result = $this->M_dashboard->getPayCount();
        $result = $result->num_rows();
        
        //json fromat
        $json["status"]="";
        $json["msg"]="";
        $json["response"]["payCount"]= $result;

        echo json_encode($json);
    }
    public function newFanshineCount() {
        $result = $this->M_dashboard->getNewFanshineCount();
        $result = $result->num_rows();

        $json["status"]="";
        $json["msg"]="";
        $json["response"]["newFanshineCount"]= $result;

        echo json_encode($json);

    }
    public function  orderCountToday(){
        $result = $this->M_dashboard->getOrderCountToday();
        $result = $result->num_rows();
        
        $json["status"]="";
        $json["msg"]="";
        $json["response"]["orderCountToday"]= $result;

        echo json_encode($json);
    }
    public function  orderAmountToday(){
        $result = $this->M_dashboard->getOrderAmountToday();
        $result = $result->result();
        $result = $result[0]->orderAmountToday;

        $json["status"]="";
        $json["msg"]="";
        $json["response"]["orderAmountToday"]= $result;
        echo json_encode($json);
        
    }
    public function orderAllDayInWeek(){
        $result = $this->M_dashboard->getOrderAllDayInWeek(); 
        $result_count = $result->num_rows();
        $result = $result->result();
        for($i = 0;$i < 7;$i++){
            if($i >= $result_count){
                $arrAmount[$i] = 0;
            }else{
                $arrAmount[$i] =  $result[$i]->ordSubTotal;
            }
        }
        $json["status"]="";
        $json["msg"]="";
        $json["response"]["categories"][0]= "Mon";
        $json["response"]["categories"][1]= "Tue";
        $json["response"]["categories"][2]= "Wed";
        $json["response"]["categories"][3]= "Thus";
        $json["response"]["categories"][4]= "Fri";
        $json["response"]["categories"][5]= "Sat";
        $json["response"]["categories"][6]= "Sun";
        $json["series"]["name"]= "Amount";
        for($i = 0;$i < 7;$i++){
            $json["series"]["data"][$i]= (int)$arrAmount[$i];
        }    
       echo json_encode($json);
    } 

    public function stockRefilsWarning(){
        $result = $this->M_dashboard->getStockRefilsWarning(); 
        $result = $result->num_rows();

        $json["status"]="";
        $json["msg"]="";
        $json["response"]["sotckRefils"]= $result;
        echo json_encode($json);
    }
}

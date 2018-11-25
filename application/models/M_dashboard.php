<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {
    
	public function getShippingCount()
	{

       //SELECT COUNT(`ordStatus`) FROM `order` WHERE `ordStatus` = 'SHIPPING'; 
       $result = $this->db->select("ordId")->from("order")->where("ordStatus","SHIPPING");

       return $this->db->get();
    }
    public function getPayCount(){
        $result = $this->db->select("ordId")->from("order")->where("ordStatus","PAYING");

        return $this->db->get();
    }
    public function getNewFanshineCount(){
        //SELECT DATEDIFF(MAX(lvuDate), NOW()) AS day FROM levelup  GROUP BY lvuCusId HAVING day < 60
        $result =  $this->db->select("DATEDIFF(MAX(lvuDate), NOW()) AS day")->from("levelup")->group_by("lvuCusId")->having("day < 60");

        return $this->db->get();
    }
    public function getOrderCountToday(){
        $date = new DateTime("now");

        $curr_date = $date->format('Y-m-d ');

        $result = $this->db->select("ordId")->from("order")->where("DATE(ordCreatedate)",$curr_date);   
        
        return $this->db->get();
    }
    public function getOrderAmountToday(){
        $date = new DateTime("now");

        $curr_date = $date->format('Y-m-d ');

        $result = $this->db->select('SUM(ordTotal) AS orderAmountToday')->from("order")->where("DATE(ordCreatedate)",$curr_date);

        return $this->db->get();
    }
    public function getOrderAllDayInWeek(){
        
        $data = new DateTime("now");
        $minDay = $data->format('Y-m-d ');
        $curr_date = $data->format('D');
        $day_of_week = date('N', strtotime($curr_date));
        $day_of_week = ($day_of_week - 1) * (-1);
        $maxday = date('Y-m-d',strtotime($day_of_week."days"));
        $result = $this->db->select("SUM(ordSubTotal) as ordSubTotal")->from("order")->where("ordCreatedate BETWEEN '$maxday' AND '$minDay'")->group_by('DATE(ordCreatedate)'); 
           
        return $this->db->get();        
    }
    public function getStockRefilsWarning(){
        $result = $this->db->select("stoId,matId,stoLast,stoActualStock,matMin")
                    ->from("stock")
                    ->join('material','matId = stoMatId')
                    ->where("stoLast = 1")
                    ->where("stoVirtualStock <= matMin ")
                    ->where("stoVirtualStock !=", 0);
        
        return $this->db->get(); 
    }       
}

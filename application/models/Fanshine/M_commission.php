<?php
class M_commission extends CI_Model {

    public function getCommissionReportList($currentPage,$limitPage,$search,$orlimit){

        $result = $this->db->select("*")
        ->from("commissionReport");

        if($orlimit == "LIMIT"){

            $offset = ($currentPage-1) * $limitPage;
            $this->db->order_by("cmrId", "DESC")
            ->limit($limitPage, $offset);
        }

        $reportList = $this->db->get();

        return $reportList;
    }
  
    public function getCommissionList($currentPage,$limitPage,$search,$orlimit, $filterColumn, $filterCondition, $filterValue, $cmsCmrId=0){

        $settingValue = $this->M_general->getSettingValue();

        $result = $this->db->select("cmsId, cmsCusId, cmsCmrId,SUM(cmsTotalPrivatePoint) AS cmsTotalPrivatePoint, SUM(cmsTotalPublicPoint) AS cmsTotalPublicPoint, SUM(cmsTotalPoint) AS cmsTotalPoint, SUM(cmsTotalCommission) AS cmsTotalCommission, cusFullName, cusCode, banName, bacNumber, bacBranch, bacName")
        ->from("commission")
        ->join("customer", "cusId = cmsCusId", "inner")
        ->join("bankAccount", "bacCusId = cusId", "inner")
        ->join("bank", "bacBanId = banId", "inner")
        ->having("cmsTotalPoint >= " . $settingValue[0]["standardPoint"])
        ->where("cmsCmrId", $cmsCmrId);

        if($search){ 

            $this->db->group_start();
            $this->db->like('cusCode', $search);
            $this->db->or_like('cusFullName', $search);
            $this->db->group_end();
        }

        if($filterColumn && $filterCondition && $filterValue){

            $this->db->having("SUM(".$filterColumn.") ".$filterCondition." ".$filterValue);
        }

        if($orlimit == "LIMIT"){

            $offset = ($currentPage-1) * $limitPage;
            $this->db->order_by("cusId", "ASC")
            ->limit($limitPage, $offset);
        }

        $this->db->group_by("cusId");

        return $this->db->get();
    }

    public function getCommissionAmount(){

        $this->db->select("SUM(cmsTotalCommission) as cmsTotalCommission")
        ->from("commission")
        ->where("cmsCmrId", 0);

        return $this->db->get();
    }

    public function generateCommissionReport(){

        // check last month have already
        $nowMonth = date("m");
        $lastMonth = $nowMonth - 1;
        if($lastMonth == 0){

            $lastMonth = 12;
        }

        // new year
        if($lastMonth == 1){

            $year = date("Y") - 1;
        }else{

            $year = date("Y");
        }

        // padding 0 to left
        $lastMonth  = str_pad($lastMonth, 2, "0", STR_PAD_LEFT);
        $year       = str_pad($year, 2, "0", STR_PAD_LEFT);

        $lastMontHaveReport = $this->db->select("cmrId")
                                ->from("commissionReport")
                                ->where("MONTH(cmrDate)", $lastMonth)
                                ->where("YEAR(cmrDate)", $year)
                                ->get()
                                ->num_rows();
     
        if(!$lastMontHaveReport){

            $this->db->trans_start();
            // Create report
            $newReport = array();
            $newReport["cmrDate"] = $year."-".$lastMonth."-1";
            $inserId = 0;
            $this->db->insert("commissionReport", $newReport);
            $lastCommissionReportId = $this->db->insert_id();

            // update commission to report
            $moveCommission = array();
            $moveCommission["cmsCmrId"] = $this->db->insert_id();

            //$this->db->where("cmsCmrId", 0)
            $this->db->where("MONTH(cmsCreatedate)", $lastMonth)
            ->where("YEAR(cmsCreatedate)", $year)
            ->update("commission", $moveCommission);

            $this->db->trans_complete();

            return $lastCommissionReportId;

        }

        return false;
    }

    public function getCommissionHistoryList($currentPage,$limitPage,$search,$orlimit, $filterColumn, $filterCondition, $filterValue, $cmsCmrId=0, $cmsCusId=0){

        $result = $this->db->select("cmsId, cmsTotalPrivatePoint ,cmsTotalPublicPoint, cmsTotalPoint, cmsTotalCommission, cusFullName, cusCode, banName, bacNumber, bacBranch, bacName, cmsCreatedate, cmsDetail, cusCode")
        ->from("commission")
        ->join("customer", "cusId = cmsCusId", "inner")
        ->join("bankAccount", "bacCusId = cusId", "inner")
        ->join("bank", "bacBanId = banId", "inner")
        ->where("cmsCmrId", $cmsCmrId)
        ->where("cmsCusId", $cmsCusId);

        if($search){ 

            $this->db->group_start();
            $this->db->like('cusCode', $search);
            $this->db->or_like('cusFullName', $search);
            $this->db->group_end();
        }

        if($filterColumn && $filterCondition && $filterValue){

            $this->db->having("SUM(".$filterColumn.") ".$filterCondition." ".$filterValue);
        }

        if($orlimit == "LIMIT"){

            $offset = ($currentPage-1) * $limitPage;
            $this->db->order_by("cusId", "ASC")
            ->limit($limitPage, $offset);
        }

        return $this->db->get();
    }

    public function getCustomerIdOfReport($cmrId){

        $settingValue = $this->M_general->getSettingValue();

        $this->db->select("cmsCusId, SUM(cmsTotalPoint) AS cmsTotalPoint, conValue")
        ->from("commission")
        ->join("customer", "cusId = cmsCusId", "inner")
        ->join("contact", "conCusId = cusId AND conName = 'EMAIL'")
        ->where("cmsCmrId", $cmrId)
        ->having("cmsTotalPoint >= " . $settingValue[0]["standardPoint"])
        ->group_by("cmsCusId");

        $customerIdOfReportList = $this->db->get()->result();

        return $customerIdOfReportList;
    }
}
?>
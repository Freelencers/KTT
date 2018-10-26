<?php

function genPagination($currentPage, $allPageNumber){

    $rang       = 3;
    $startPage  = $currentPage - $rang;
    $endPage    = $currentPage + $rang;
    
    if($startPage < 1){

        $startPage = 1;
    }

    if($endPage >= $allPageNumber){

        $endPage = $allPageNumber;
    }

    // set data format
    $pagination = array();
    for($i=$startPage;$i<=$endPage;$i++){

        $element["page"] = $i;

        if($i == $currentPage){

            $element["status"] = "active";
        }else{

            $element["status"] = "";
        }

        array_push($pagination, $element);
    }

    return $pagination;
}

function convertSettingFormat($settingList){

    $ssgIdTemp = 0;
    $settingNewFormat = array();
    $index = -1;
    $round = 0;
    foreach($settingList as $row){

        if($row->ssgId != $ssgIdTemp){

            $ssgIdTemp = $row->ssgId;
            $index++;
            
            // initial data
            $settingNewFormat[$index]["ssgId"]                 = $row->ssgId;
            $settingNewFormat[$index]["dateStart"]             = $row->ssgDateStart;
            $settingNewFormat[$index]["dateEnd"]               = $row->ssgDateEnd;

            $settingNewFormat[$index]["standardPoint"]         = 0;
            $settingNewFormat[$index]["pointToMoneyLevelS"]    = 0;
            $settingNewFormat[$index]["pointToMoneyLevelL"]    = 0;
            $settingNewFormat[$index]["commission"]            = 0;
            $settingNewFormat[$index]["moneyToPoint"]          = 0;
            $settingNewFormat[$index]["refer"]                 = 0;
            $settingNewFormat[$index]["pounderWeight"]         = 0;
            $settingNewFormat[$index]["tax"]                   = 0;
            $settingNewFormat[$index]["sFee"]                  = 0;
            $settingNewFormat[$index]["lFee"]                  = 0;
        }

        switch($row->sscName){

            case "pointToMoneyLevelS" :   $settingNewFormat[$index]["pointToMoneyLevelS"]    = $row->sscValue; 
                                            break;
            case "pointToMoneyLevelL" :   $settingNewFormat[$index]["pointToMoneyLevelL"]    = $row->sscValue; 
                                            break;
            case "commission"          :   $settingNewFormat[$index]["commission"]             = $row->sscValue;
                                            break;
            case "moneyToPoint"        :   $settingNewFormat[$index]["moneyToPoint"]          = $row->sscValue;
                                            break;
            case "refer"               :   $settingNewFormat[$index]["refer"]                 = $row->sscValue;
                                            break;
            case "pounderWeight"       :   $settingNewFormat[$index]["pounderWeight"]         = $row->sscValue;
                                            break;
            case "tax"                 :   $settingNewFormat[$index]["tax"]                   = $row->sscValue;
                                            break;
            case "sFee"               :   $settingNewFormat[$index]["sFee"]                  = $row->sscValue;
                                            break;
            case "lFee"               :   $settingNewFormat[$index]["lFee"]                  = $row->sscValue;
                                            break;
            case "standardPoint"       :   $settingNewFormat[$index]["standardPoint"]         = $row->sscValue;
                                            break;
        }

    }

    return $settingNewFormat;
}
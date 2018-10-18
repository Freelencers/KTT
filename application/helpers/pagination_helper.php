<?php

function genPagination($currentPage, $allPageNumber){

    $rang       = 3;
    $startPage  = $currentPage - $rang;
    $endPage    = $currentPage + $rang;

    if($startPage < 1){

        $startPage = 1;
    }

    if($endPage > $allPageNumber){

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
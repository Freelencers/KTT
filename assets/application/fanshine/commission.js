// On load
var currentPageCommission = 1;
var limitPageCommission = 10;

var currentPageReport = 1;
var limitPageReport = 5;

var cmsCmrId = 0;

loadCommissionTable(currentPageCommission, limitPageCommission, "", cmsCmrId);
loadReportTable(currentPageReport, limitPageReport, "");
loadCommissionAmount();
getCommissionDateRang();


// on action

$(document).on("click", ".paginationReportList > .paginate_button", function(){

    currentPage = $(this).data("page");
    loadCommissionTable(currentPage, limitPage, "", cmsCmrId);
});

$(document).on("click", ".paginationCommissionList > .paginate_button", function(){

    currentPage = $(this).data("page");
    loadReportTable(currentPage, limitPage, "");
});

$(".filter").change(function(){

    loadCommissionTable(currentPageCommission, limitPageCommission, "", cmsCmrId); 
});

$(document).on("click", ".getReportDetail", function(){
    
    cmsCmrId = $(this).attr("cmrId");
    loadCommissionTable(currentPageCommission, limitPageCommission, "", cmsCmrId); 
});

$(document).on("click", ".generatePdfTransfer", function(){

    var cmrId = $(this).attr("cmrId");
    window.open(base_url + "/Fanshine/Commission/generatePdfTransferList/" + cmrId, '_blank');
});

$(document).on("click", ".generateCommissionDetailPdf", function(){

    var cmsCusId = $(this).attr("cmsCusId");
    var cmsCmrId = $(this).attr("cmsCmrId");
    window.open(base_url + "/Fanshine/Commission/generatePdfCommissionDetail/" + cmsCmrId + "/" + cmsCusId, '_blank');
});
// defination

function loadCommissionTable(currentPage, limitPage, search, cmsCmrId){

    var json = {
        "currentPage"       : currentPage,
        "limitPage"         : limitPage,
        "search"            : $("#search").val(),
        "filterColumn"      : $("#filterColumn").val(),
        "filterCondition"   : $("#filterCondition").val(),
        "filterValue"       : $("#filterValue").val(),
        "cmsCmrId"          : cmsCmrId
    };
    $.post(base_url + "/Fanshine/Commission/getCommissionList", json, function(resp){

        var columnTemplate = $("#rowTemplateCommission tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 9);
        }
        resp.response.dataList.forEach(function(row){
            replace = {
                "{code}"          : row.cusCode,
                "{fanshineName}"  : row.cusFullName,
                "{bank}"          : row.banName,
                "{bankAccount}"   : row.bacNumber,
                "{privatePoint}"  : moneyNumberFormat(row.cmsTotalPrivatePoint),
                "{companyPoint}"  : moneyNumberFormat(row.cmsTotalPublicPoint),
                "{amount}"        : moneyNumberFormat(row.cmsTotalPoint),
                "{commission}"    : moneyNumberFormat(row.cmsTotalCommission),
                "{cmsId}"         : row.cusId,
                "{cmsCmrId}"      : row.cmsCmrId,
                "{cmsCusId}"      : row.cmsCusId,
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyCommissionList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationCommissionList").html(pagination);
    },"json");
}

function loadReportTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/Fanshine/Commission/getCommissionReportList", json, function(resp){

        var columnTemplate = $("#rowTemplateReport tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", "7");
        }
        resp.response.dataList.forEach(function(row){
            replace = {
                "{cmrDate}"        : convertDateToHuman(row.cmrDate),
                "{cmrId}"          : row.cmrId,
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyReportList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationReportList").html(pagination);
    },"json");
}

function loadCommissionAmount(){
    $.post(base_url + "/Fanshine/Commission/getCommissionAmount", {}, function(resp){

        if(resp.response.amount === null){

            $("#commissionAmount").text(0);
        }else{

            $("#commissionAmount").text(moneyNumberFormat(resp.response.amount));
        }
    }, "json");
}

function getCommissionDateRang(){

    var d       = new Date();
    var strDate = "";
    var lastDay = new Date(d.getFullYear(), d.getMonth() + 1, 0);


    strDate  = "1/" + (parseInt(d.getMonth()) + 1) + "/" + (parseInt(d.getFullYear()) + 543) + " - ";
    strDate += lastDay.getDate() + "/" + (parseInt(d.getMonth()) + 1) + "/" + parseInt(d.getFullYear() + 543);

    $("#commissionTime").text(strDate);
}
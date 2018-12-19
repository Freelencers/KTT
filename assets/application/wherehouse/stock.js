// On load
var currentPage = 1;
var limitPage = 10;
var stockCondition = "";
var stockCondition = new Array();
var keyword = "";

loadTable(currentPage, limitPage, "");
loadLocation();
loadStockRefils();


// on action
$(".matAmountOutput").keyup(function(){

    var max = localStorage.getItem("VirtalStock");
    if(parseInt($(this).val()) > parseInt(max)){

        $(this).val(max);
    }
});

$(document).on("click", ".paginate_button", function(){

    currentPage = $(this).data("page");
    loadTable(currentPage, limitPage, keyword);
    loadHistoryTable(currentPage, limitPage, keyword);
});

$("#search").change(function(){

    keyword = $(this).val();
    loadTable(currentPage, limitPage, keyword);
    loadHistoryTable(currentPage, limitPage, keyword); 
});

$(".stockCondition").change(function(){

    var condition = $(this).attr("condition");
    if(this.checked) {

        stockCondition.push(condition);
    }else{

        // remove condition from array
        var index = stockCondition.indexOf(condition);
        if (index !== -1){

            stockCondition.splice(index, 1);
        }
    }

    loadTable(currentPage, limitPage, keyword); 
});

$(document).on("click", ".inputStock", function(){

    var matId = $(this).attr("matId");
    localStorage.setItem("matId", matId);

    // clear form
    clearDataForm("#inputStockForm");

     // get material detail
     var matId = $(this).attr("matId");
     $.post(base_url + "/Wherehouse/Product/getProductDetailById", {"matId": matId}, function(resp){
 
         $(".matCode").val(resp.response.dataRow.matCode);
         $(".matName").val(resp.response.dataRow.matName);
     },"json");

     $.post(base_url + "/Wherehouse/Stock/getLastCost", {"matId": matId}, function(resp){

        $("#matCost").val(resp.response.lastCost);
     },"json");

    $("#modal-inputStock").modal();
});

$(document).on("click", ".outputStock", function(){

    var matId = $(this).attr("matId");
    localStorage.setItem("matId", matId);

    // clear form
    clearDataForm("#outputStockForm");

     // get material detail
     var matId = $(this).attr("matId");
     $.post(base_url + "/Wherehouse/Stock/getProductStockDetail", {"matId": matId, "locationMode" : "OUTPUT"}, function(resp){
 
         $(".matCode").val(resp.response.dataRow.matCode);
         $(".matName").val(resp.response.dataRow.matName);

         //set stock for check input box
         localStorage.setItem("VirtalStock", resp.response.dataRow.matLocationList[0].stoVirtualStock);

         // Location
         var optionTemplate = $("#option").html();
         var options = "";
         if(!resp.response.dataRow.matLocationList.length){
 
             options = $("#option").html();
             options = option.replace("{title}", "No Data");
         }

         // Auto Mode option
         replace = {
            "{title}" : "Auto mode",
            "{value}" : "AUTO-MODE"
        }
        options += replaceAll(optionTemplate, replace);

        resp.response.dataRow.matLocationList.forEach(function(row){
 
             replace = {
                 "{title}" : row.locName + " - " + row.stoVirtualStock + " " + row.untName,
                 "{value}" : row.locId
             }
             options += replaceAll(optionTemplate, replace);
         });
         $(".matLocStock").html(options);
     },"json");

    $("#modal-outputStock").modal();
});

$("#actionInputStock").click(function(){

    if(validate(".validateInputStock")){

        var inputData = getDataForm("#inputStockForm");
        inputData["matId"] = localStorage.getItem("matId");
        inputData["matExpDate"] = convertDateToDatabase($("#matExpDate").val());

        $.post(base_url + "/Wherehouse/Stock/inputStock", inputData, function(resp){

            loadTable(currentPage, limitPage, "");
            $("#modal-inputStock").modal("hide");
        },"json");
    }
});

$("#actionOutputStock").click(function(){

    if(validate(".validateOutputStock")){
        
        var outputData = getDataForm("#outputStockForm");
        outputData["matId"] = localStorage.getItem("matId");

        $.post(base_url + "/Wherehouse/Stock/outputStock", outputData, function(resp){

            loadTable(currentPage, limitPage, "");
            $("#modal-outputStock").modal("hide");
        },"json");
    }
});

$(".tabs").click(function(){

    var tabName = $(this).attr("tabName");

    switch(tabName){
        case "STOCK"    :   loadTable(currentPage, limitPage, "");
                            break;
        case "HISTORY"  :   loadHistoryTable(currentPage, limitPage, "");
                            break;
    }
});

// Definition

function loadTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search,
        "matType" : "",
        "stockCondition": stockCondition
    };

    $.post(base_url + "/Wherehouse/Stock/getStockList", json, function(resp){

        var columnTemplate = $("#rowTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        var Hightlight = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 7);
        }
        resp.response.dataList.forEach(function(row){

            // Hightlight
            Hightlight = "";
            if(parseFloat(row.stoActualStock) === 0){

                Hightlight = "alert alert-danger alert-dismissible";
            }else if(parseFloat(row.stoVirtualStock) <= parseFloat(row.matMin)){

                Hightlight = "alert alert-warning alert-dismissible";
            }



            replace = {
                "{no}" : no + 1,
                "{matCode}" : row.matCode,
                "{matId}" : row.matId,
                "{matName}" : row.matName,
                "{matType}" : row.matType,
                "{stoActualStock}" : row.stoActualStock,
                "{stoVirtualStock}" : row.stoVirtualStock,
                "{hightLight}" : Hightlight
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tableStockList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);

    },"json");
}

function loadHistoryTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search,
        "matType" : "",
        "stockCondition": stockCondition
    };

    $.post(base_url + "/Wherehouse/Stock/getStockHistoryList", json, function(resp){

        var columnTemplate = $("#rowTemplateHistory tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        var Hightlight = "";
        var shtType = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 10);
        }
        resp.response.dataList.forEach(function(row){

            // Action label
            if(row.shtType == "INPUT"){

                shtType = $("#inputStockLabel").html();
            }else{

                shtType = $("#outputStockLabel").html();
            }

            replace = {
                "{no}" : no + 1,
                "{matCode}" : row.matCode,
                "{matId}" : row.matId,
                "{matName}" : row.matName,
                "{matType}" : row.matType,
                "{stoCost}" : row.stoCost,
                "{locName}" : row.locName,
                "{shtTotal}" : row.shtTotal,
                "{shtAmount}" : row.shtAmount,
                "{shtActionDate}" : row.shtActionDate,
                "{shtType}" : shtType,
                "{stoReason}" : row.stoReason
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tableStockHistoryList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);

    },"json");
}

function loadLocation(){

    var json = {
        "currentPage" : 1,
        "limitPage" : 100,
        "search" : "" 
    };

    $.post(base_url + "/Wherehouse/Location/getLocationList", json, function(resp){

        var optionTemplate = $("#option").html();
        var options = "";
        if(!resp.response.dataList.length){

            options = $("#option").html();
            options = option.replace("{title}", "No Data");
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{title}" : row.locName + " : " + row.locDetail,
                "{value}" : row.locId,
            }
            options += replaceAll(optionTemplate, replace);
        });
        $("#matLocId").html(options);
    },"json");
}

function loadStockRefils(){

    $.post(base_url + "/System/Dashboard/stockRefilsWarning", "", function(resp){

        $("#stockRefils").text(resp.response.stockRefils);
    },"json");
}

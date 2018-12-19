// On load
var currentPage = 1;
var limitPage = 10;

loadTable(currentPage, limitPage, "");
loadLocation(1, 1000, "");
loadUnit(1, 1000, "");

// on action


$(document).on("click", ".paginate_button", function(){

    currentPage = $(this).data("page");
    loadTable(currentPage, limitPage, "");
});

$("#deleteButtonConfirm").click(function(){

    var matId = $(this).data("id");
    $.post(base_url + "/Wherehouse/Product/deleteProduct", {"matId" : matId}, function(resp){

        $("#modal-deleteConfirm").modal("hide");
        loadTable(currentPage, limitPage, "");
    });
});

// Create button click
$("#modalSaveButton").click(function(){

    if(validate(".validate")){

        createNewProduct();
    }
});

$("#createNewProductButton").click(function(){

    localStorage.setItem("createStatus", "CREATE");
    clearDataForm("#materialForm");
    $("#modal-createNewProduct").modal();
});

$(document).on("click", ".changMaterialDetail", function(){

    if(validate(".validate")){
        
        var matId = $(this).attr("matId");

        // assign to local storage
        localStorage.setItem("matId", matId);
        localStorage.setItem("createStatus", "UPDATE");

        $.post(base_url + "/Wherehouse/Product/getProductDetailById", {"matId": matId}, function(resp){

            pushDataForm("#materialForm", resp.response.dataRow);
            $("#modal-createNewProduct").modal("show");
        },"json");
    }
});
// Definition

function loadTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/Wherehouse/Product/getProductList", json, function(resp){

        var columnTemplate = $("#rowTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 9);
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{no}" : no + 1,
                "{matId}" : row.matId,
                "{matCode}" : row.matCode,
                "{matName}" : row.matName,
                "{locName}" : row.locName,
                "{untName}" : row.untName,
                "{matMin}" : row.matMin,
                "{matMax}" : row.matMax,
                "{matType}" : row.matType,
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyAccountList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);

    },"json");
}

function createNewProduct(){

    // get value from
    var json = getDataForm("#materialForm");

    // Check status of add
    var status = localStorage.getItem("createStatus");
    if(status == "UPDATE"){

        json["matId"] = localStorage.getItem("matId");
        $.post(base_url + "/Wherehouse/Product/updateProduct", json, function(){

            loadTable(currentPage, limitPage, "");
            $("#modal-createNewProduct").modal("hide");
            clearDataForm("#materialForm");
        });
    }else{

        $.post(base_url + "/Wherehouse/Product/createNewProduct", json, function(resp){

            loadTable(currentPage, limitPage, "");
            $("#modal-createNewProduct").modal("hide");
            clearDataForm("#materialForm");
        },"json");
    }

   
}

function loadLocation(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/Wherehouse/Location/getLocationList", json, function(resp){

        var optionTemplate = $("#option").html();
        var options = "";
        if(!resp.response.dataList.length){

            replace = {
                "{value}" : "",
                "{title}" : "No Data",
                "{selected}" : ""
            }
            options += replaceAll(optionTemplate, replace);
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{value}" : row.locId,
                "{title}" : row.locName + " : " + row.locDetail,
                "{selected}" : ""
            }
            options += replaceAll(optionTemplate, replace);
        });
        $("#matLocId").html(options);
    },"json");
}

function loadUnit(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/Wherehouse/Product/getUnitList", json, function(resp){

        var optionTemplate = $("#option").html();
        var options = "";
        if(!resp.response.dataList.length){

            replace = {
                "{value}" : "",
                "{title}" : "No Data",
                "{selected}" : ""
            }
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{value}" : row.untId,
                "{title}" : row.untName,
                "{selected}" : ""
            }
            options += replaceAll(optionTemplate, replace);
        });
        $("#matUntId").html(options);
    },"json");
}
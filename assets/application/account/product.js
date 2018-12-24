// On load
var currentPage = 1;
var currentPageMaterial = 1;
var limitPage = 10;

// Fix bug
var matId = 0;

loadTable(currentPage, limitPage, "");
loadMaterialList(currentPageMaterial, 5);

// on action

$(document).on("click", ".paginationList > .paginate_button", function(){

    currentPage = $(this).data("page");
    loadTable(currentPage, limitPage, "");
});

$(document).on("click", ".paginationMaterialList > .paginate_button", function(){

    currentPageMaterial = $(this).data("page");
    loadMaterialList(currentPageMaterial, 5);
});

$("#searchMaterial").change(function(){

    loadMaterialList(currentPageMaterial, 5);
});

$("#deleteButtonConfirm").click(function(){

    var prdId = $(this).data("id");
    $.post(base_url + "/Account/Product/deleteProduct", {"prdId" : prdId}, function(resp){

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
    clearDataForm("#productForm");

    $("#materialTable").show();
    $("#showMatName").hide();

    $("#modal-createNewProduct").modal();
});

$(document).on("click", ".changProductDetail", function(){

    // show material name
    $("#showMatName").show();
    $("#materialTable").hide();

    var prdId = $(this).attr("prdId");

    // assign to local storage
    localStorage.setItem("prdId", prdId);
    localStorage.setItem("createStatus", "UPDATE");

    $.post(base_url + "/Account/Product/getProductDetailById", {"prdId": prdId}, function(resp){

        pushDataForm("#productForm", resp.response.dataRow);
        $("#modal-createNewProduct").modal("show");
    },"json");
});


$("#prdFullPrice , #prdDiscount").change(function(){

    var fullPrice = $("#prdFullPrice").val();
    var discount = $("#prdDiscount").val();

    if(!isNaN(fullPrice) && !isNaN(discount)){

        $("#prdTotal").val(fullPrice - discount);

        // Calculate point
        $.post(base_url + "/General/getSettingValue", "", function(resp){

            $("#prdPoint").val(resp[0].moneyToPoint * (fullPrice - discount));
        }, "json");
    }
});

$(document).on("click", ".matIdRadio", function(){

    console.log($(this).val());
    localStorage.setItem("prdMatId", $(this).val());
});

// Definition

function loadTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/Account/Product/getProductList", json, function(resp){

        var columnTemplate = $("#rowTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 4);
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{no}" : no + 1,
                "{prdId}" : row.prdId,
                "{prdMatCode}" : row.prdMatCode,
                "{prdMatName}" : row.prdMatName
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyProductList").html(tbody);

        // pagination
        console.log(resp.response.pagination);
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);
        console.log(pagination);

    },"json");
}

function createNewProduct(){

    // get value from
    var json = getDataForm("#productForm");

    // Check status of add
    var status = localStorage.getItem("createStatus");

    // get matId from radio
    json["prdMatId"] = localStorage.getItem("prdMatId");

    if(status == "UPDATE"){

        json["prdId"] = localStorage.getItem("prdId");
        $.post(base_url + "/Account/Product/updateProductDetail", json, function(){

            loadTable(currentPage, limitPage, "");
            $("#modal-createNewProduct").modal("hide");
            clearDataForm("#materialForm");
        });
    }else{

        $.post(base_url + "/Account/Product/createNewProduct", json, function(resp){

            loadTable(currentPage, limitPage, "");
            $("#modal-createNewProduct").modal("hide");
            clearDataForm("#productForm");
        },"json");
    }

   
}

function loadMaterialList(currentPage, limitPage){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : $("#searchMaterial").val()
    };
    $.post(base_url + "/Wherehouse/Product/getProductList", json, function(resp){

        var columnTemplate = $("#materialTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 3);
        }
        resp.response.dataList.forEach(function(row){

            if(no === 0){

                localStorage.setItem("prdMatId", row.matId);
                checked = "checked";
            }else{

                checked = "";
            }

            replace = {
                "{no}" : no + 1,
                "{matId}" : row.matId,
                "{matCode}" : row.matCode,
                "{matName}" : row.matName,
                "{checked}" : checked
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyMatarialList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationMaterialList").html(pagination);

    },"json");
}


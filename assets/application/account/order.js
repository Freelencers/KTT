// On load
var currentPage = 1;
var currentPageMaterial = 1;
var limitPage = 10;

loadTable(currentPage, limitPage, "");

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

    var ordId = $(this).data("id");
    $.post(base_url + "/Account/Order/deleteOrder", {"ordId" : ordId}, function(resp){

        $("#modal-deleteConfirm").modal("hide");
        loadTable(currentPage, limitPage, "");
    });
});

$(document).on("click", ".changeOrder", function(){

    var ordId = $(this).attr("ordId");
    window.open(base_url + "/Font-end/Account/Order/createOrder/" + ordId, '_blank');
});


// Create button click
$("#modalSaveButton").click(function(){

    createNewProduct();
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

$(document).on("click", ".nextStatus", function(){

    var ordId = $(this).attr("ordId");
    $.post(base_url + "/Account/Order/updateOrderStatus", {"ordId": ordId}, function(resp){

        loadTable(currentPage, limitPage, "");
    });
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

$(document).on("click", ".buttonGeneratePDF", function(){
    
    var ordId = $(this).attr("ordId");
    window.open(base_url + "/Account/Order/generateInvoicePDF/" + ordId + "/0/0/0", '_blank');
});

// Definition

function loadTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/Account/Order/getOrderList", json, function(resp){

        var columnTemplate = $("#orderTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 6);
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{no}" : no + 1,
                "{ordCreatedate}" : convertDateToHuman(row.ordCreatedate),
                "{ordId}" : row.ordId,
                "{cusFullName}" : row.cusFullName,
                "{ordCode}" : row.ordCode,
                "{ordTotal}" : row.ordTotal,
                "{ordStatus}" : orderStatusLabel(row.ordStatus)
            }

            if(row.ordStatus != "WAIT-PAY"){
                
                replace["{hideRemoveIcon}"] = "hide";
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyOrderList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);
    },"json");
}

function orderStatusLabel(status){

    if(language == "english"){

        switch(status){

            case "WAIT-PAY" : return "<span class='badge bg-yellow'>Waiting Pay</span>";
                              break;

            case "PAYED"    : return "<span class='badge bg-teal'>Pay Already</span>";
                              break;

            case "SHIPPING" : return "<span class='badge bg-maroon'>Shipping</span>";
                              break;

            case "SHIPPED"  : return "<span class='badge bg-green'>Ship Already</span>"
                              break;
        }
    }else{

        switch(status){

            case "WAIT-PAY" : return "<span class='badge bg-yellow'>รอการชำระเงิน</span>";
                              break;

            case "PAYED"    : return "<span class='badge bg-teal'>จ่ายแล้ว</span>";
                              break;

            case "SHIPPING" : return "<span class='badge bg-maroon'>กำลังจัดส่ง</span>";
                              break;

            case "SHIPPED"  : return "<span class='badge bg-green'>จัดส่งเรียบร้อย</span>"
                              break;
        }
    }
}
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
    $.post(base_url + "/Account/OrderHistory/getOrderHistory", json, function(resp){

        var columnTemplate = $("#orderTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 6);
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{date}" : convertDateToHuman(row.ordCreatedate),
                "{orderCode}" : row.ordCode,
                "{ordId}" : row.ordId,
                "{fanshineName}" : row.cusFullName,
                "{amount}" : moneyNumberFormat(row.ordTotal),
                "{status}" : orderStatusLabel(row.ordStatus)
            }
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

            case "SUCCESS"  : return "<span class='badge bg-green'>Order Complete</span>"
                              break;

            case "SHOPPING"  : return "<span class='badge bg-gray'>Order Not Complete</span>"
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

            case "SUCCESS"  : return "<span class='badge bg-green'>เสร็จสิ้น</span>"
                              break;

            case "SHOPPING"  : return "<span class='badge bg-gray'>การสั่งซื้อไม่สมบูรณ์</span>"
                              break;
        }
    }
}

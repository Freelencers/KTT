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
                "{amount}" : row.ordTotal,
                "{status}" : row.ordStatus
            }
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyOrderList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);
    },"json");
}

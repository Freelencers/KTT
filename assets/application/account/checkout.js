// On load
var currentPageProduct = 1;
var currentPageMyOrder = 1;
var limitPage = 9;
var keyword = "";
var totalPoint = 0;
loadOrderProductList();
getInvoidDetail();

// on action
$("#shipping").change(function(){

    var subTotal = $("#subTotal").attr("value");
    calculateSum(subTotal);
});

$("#complete").click(function(){

    var subTotal = $("#subTotal").attr("value");
    var tax = $("#tax").attr("value");
    var shipping = $("#shipping").val();

    window.location.replace(base_url + "/Account/Order/complete/" + subTotal + "/" + tax + "/" + shipping + "/true/" + totalPoint);
})

$("#buttonGeneratePDF").click(function(){
    
    var subTotal = $("#subTotal").attr("value")
    var tax = $("#tax").attr("value");
    var shipping = $("#shipping").val();

    window.open(base_url + "/Account/Order/generateInvoicePDF/0/" + subTotal + "/" + tax + "/" + shipping, '_blank');
});
// Definition

function loadOrderProductList(){

    var json = {
        "currentPage" : 1, 
        "limitPage" : 1000,
        "search" : ""
    };

    $.post(base_url + "/Account/Order/getMyOrderList", json, function(resp){

        var component = $("#invoidTemplate tbody").html();
        var rows = "";
        var sumPoint = 0;
        var sumPrice = 0;

        if(!resp.response.dataList.length){

            rows = $("#noDataRow tbody").html();
            rows = rows.replace("{colspan}", 4);
        }
        resp.response.dataList.forEach(function(row){

            // Create card
            replace = {
                "{sodQty}" : moneyNumberFormat(row.sodQty),
                "{untName}" : row.untName,
                "{point}" : moneyNumberFormat(row.prdPoint * row.sodQty),
                "{price}" : moneyNumberFormat(row.prdFullPrice - row.prdDiscount) * row.sodQty,
                "{matName}" : row.matName
            }

            totalPoint += (row.prdPoint * row.sodQty);
            rows += replaceAll(component, replace);

            // Calculate sumary
            sumPrice += (parseFloat(row.prdFullPrice) - parseFloat(row.prdDiscount)) * row.sodQty;
            
        });

        calculateSum(sumPrice);
        $("#tbodyInvoid").html(rows);
        $("#subTotal").text(moneyNumberFormat(sumPrice));
        $("#subTotal").attr("value", sumPrice);

    }, "json");
}

function calculateSum(subTotal){

    subTotal       = parseFloat(subTotal);
    var shipping   = parseFloat($("#shipping").val());
    var tax        = 0;
    var grandTotal = 0;

    // Calculate point
    $.post(base_url + "/General/getSettingValue", "", function(resp){

        tax         = ((resp[0].tax * 0.01) * (subTotal + shipping));
        grandTotal  = ((resp[0].tax * 0.01) * (subTotal + shipping)) + subTotal + shipping;
        $("#tax").text(moneyNumberFormat(tax));
        $("#tax").attr("value", tax);
        $("#grandTotal").text(moneyNumberFormat(grandTotal));

    }, "json");

}

function getInvoidDetail(){

    $.post(base_url + "/Account/Order/getInvoiceDetail", "", function(resp){

        $("#cusCode").text(resp.OrderDetail.cusCode);
        $("#ordCreatedate").text(convertDateToHuman(resp.OrderDetail.ordCreatedate));
        $("#ordCode").text(resp.OrderDetail.ordCode);

        $("#accountName").text(resp.OrderDetail.bacName);
        $("#accountNo").text(resp.OrderDetail.bacNo);
        $("#accountBranch").text(resp.OrderDetail.bacBranch);
        $("#accountType").text(resp.OrderDetail.bacType);

        // Address
        $("#cusFullName").text(resp.OrderDetail.cusFullName);
        $("#addDetail").text(resp.addressDetail.addDetail);
        $("#prvName").text(resp.addressDetail.prvName);
        $("#disName").text(resp.addressDetail.disName);
        $("#addPostcode").text(resp.addressDetail.addPostcode);

        resp.contactDetail.forEach(function(row){

            switch(row.conName){
                case "EMAIL" :  $("#email").text(row.conValue);
                                break;

                case "PHONE" :  $("#phone").text(row.conValue);
                                break;
            }
        });
    }, "json");
}


// On load
var currentPageProduct = 1;
var currentPageMyOrder = 1;
var limitPage = 9;
var keyword = "";

// product cart
var cart = new Array();

loadCustomerList();
loadProduct();
loadMyOrder()

// on action
$("#searchCustomer").change(function(){

    var code = $("#searchCustomer").val();
    loadCustomerList(code);
});

$(document).on("click", ".paginationProductList > .paginate_button", function(){

    currentPageProduct = $(this).data("page");
    loadProduct(currentPageProduct, limitPage, keyword);
});

$(document).on("click", ".paginationMyOrderList > .paginate_button", function(){

    currentPageMyOrder = $(this).data("page");
    loadMyOrder(currentPageProduct, limitPage, keyword);
});

$("#search").change(function(){

    keyword = $("#search").val();
    loadProduct(currentPageProduct, limitPage, keyword);
});


$(document).on("click", ".addProductToCrat", function(){

    var prdId = $(this).attr("prdId");
    var stock = $(this).attr("stock");

    // check prdId define to index of array?
    if(cart[prdId] == void 0){

        cart[prdId] = 1; 
        updateAmountOfProduct("ADD", prdId);
    }else{

        if(parseInt(cart[prdId]) < parseInt(stock)){

            cart[prdId] += 1; 
            updateAmountOfProduct("ADD", prdId);
        }
    }
});

$(document).on("click", ".removeProductToCrat", function(){

    var prdId = $(this).attr("prdId");
    if(cart[prdId] == void 0){

        cart[prdId] = 0; 
    }else{

        if(cart[prdId] > 0){

            cart[prdId] -= 1; 
            updateAmountOfProduct("REMOVE", prdId);
        }
    }
    
});

$(document).on("click", ".removeOrder", function(){

    // remove product in memory 
    var prdId = $(this).attr("prdId");
    cart[prdId] = 0;

    var json = {
        "sodId" : $(this).attr("sodId")
    };
    $.post(base_url + "/Account/Order/removeFromCart", json, function(){

        loadMyOrder();
        $(".amountOfProduct").each(function(){

            var prdId = $(this).attr("prdId");
            if(cart[prdId] != void 0){
    
                $(this).text(cart[prdId]);
            }
        });
    });
});


$("#checkout").click(function(){

    var cusCode = $("#customerList").val();
    console.log("cusCode : " + cusCode);
    if(cusCode > 0){

        window.location.replace(base_url + "/Font-end/Account/Order/checkout/" + cusCode);
    }else{

        console.log(language);
        if(language == "english"){

            modalMessage("Select customer for this order");
        }else{

            modalMessage("กรุณาเลือกลูกค้าที่ทำการสั่งซื้อ");
        }
    }
});


// Definition

function loadCustomerList(code){

    var json = {
        "currentPage" : currentPageProduct,
        "limitPage" : limitPage,
        "search" : code 
    };
    $.post(base_url + "/Fanshine/Customer/getCustomerList", json, function(resp){

        // Location
        var optionTemplate = $("#option").html();
        var options = "";
        if(!resp.response.dataList.length){ 

            replace = {
                "{title}" : "No Data",
                "{value}" : ""
            }
            options += replaceAll(optionTemplate, replace);
        }else{

            replace = {
                "{title}" : "Select customer",
                "{value}" : 0
            }
            options += replaceAll(optionTemplate, replace);

            resp.response.dataList.forEach(function(row){

                replace = {
                    "{title}" : row.cusCode + " - " + row.cusFullName,
                    "{value}" : row.cusId
                }
                options += replaceAll(optionTemplate, replace);
            });
        }

        $("#customerList").html(options);
    }, "json");
}

function loadProduct(){

    var json = {
        "currentPage" : currentPageProduct, 
        "limitPage" : 9,
        "search" : keyword
    };

    $.post(base_url + "/Account/Order/getProductList", json, function(resp){

        // Location
        var component = $("#cardProductComponent").html();
        var cardList = "";

        if(!resp.response.dataList.length){

            cardList = $("#noDataCard").html();
        }
       resp.response.dataList.forEach(function(row){

            console.log("TEST");
            replace = {
                "{code}" : row.matCode,
                "{prdId}" : row.prdId,
                "{point}" : row.prdPoint,
                "{price}" : (row.prdFullPrice - row.prdDiscount),
                "{stock}" : row.stoVirtualStock + " " + row.untName,
                "{matName}" : row.matName,
                "{matId}" : row.matId
            }
            cardList += replaceAll(component, replace);
        });
        $("#productCategory").html(cardList);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationProductList").html(pagination);

        $(".amountOfProduct").each(function(){

            var prdId = $(this).attr("prdId");
            if(cart[prdId] != void 0){
    
                $(this).text(cart[prdId]);
            }
        });

    }, "json");
}

function loadMyOrder(){

    var json = {
        "currentPage" : currentPageMyOrder, 
        "limitPage" : 9,
        "search" : keyword
    };

    $.post(base_url + "/Account/Order/getMyOrderList", json, function(resp){

        var component = $("#cardMyProductCompenent").html();
        var cardList = "";
        var sumPoint = 0;
        var sumPrice = 0;

        if(!resp.response.dataList.length){

            cardList = $("#noDataCard").html();
        }
        resp.response.dataList.forEach(function(row){

            // Create card
            replace = {
                "{code}" : row.matCode,
                "{sodId}" : row.sodId,
                "{prdId}" : row.prdId,
                "{point}" : row.prdPoint,
                "{price}" : (row.prdFullPrice - row.prdDiscount),
                "{stock}" : row.stoVirtualStock,
                "{matName}" : row.matName,
                "{amount}" : row.sodQty,
                "{matId}" : row.matId,
                "{untName}" : row.untName
            }
            cardList += replaceAll(component, replace);

            // Calculate sumary
            sumPrice += (parseFloat(row.prdFullPrice) - parseFloat(row.prdDiscount)) * row.sodQty;
            sumPoint += parseFloat(row.prdPoint) * row.sodQty;
        });

        $("#myProductCategory").html(cardList);
        $("#sumPoint").text(sumPoint);
        $("#sumPrice").text(sumPrice);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationMyOrderList").html(pagination);
    }, "json");
}

function updateAmountOfProduct(mode, prdId){

    var json = {
        "sodPrdId" : prdId,
        "action" : mode,
        "sodQty" : 1
    }
    $.post(base_url + "/Account/Order/addToCart", json, function(resp){

        if(resp.status == 200){

            loadMyOrder();
        }
    },"json");

    $(".amountOfProduct").each(function(){

        var prdId = $(this).attr("prdId");
        if(cart[prdId] != void 0){

            $(this).text(cart[prdId]);
        }
    });
}

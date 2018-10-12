// on load
payCount();

// on aciton
// defination

function payCount(){

    // https://api.myjson.com/bins/12hoto
    $.post(base_url + "/System/Dashboard/payCount", "", function(resp){

        $("#payCount").text(resp.response.payCount);
    }, "json");
}

function shippingOrder(){

    $.post(base_url + "/System/Dashboard/shippingCount", "", function(resp){

        $("#shppingCount").text(resp.response.shippingCount);
    }, "json");
}

function newFanshine(){

    $.post(base_url + "/System/Dashboard/newFanshine", "", function(resp){

        $("#newFanshine").text(resp.response.newFanshine);
    }, "json");
}

function stockRefils(){

    $.post(base_url + "/System/Dashboard/stockRefilsWarning", "", function(resp){

        $("#stockRefils").text(resp.response.stockRefils);
    }, "json");
}

function orderCount(){

    $.post(base_url + "/System/Dashboard/orderCountToday", "", function(){

        $("#orderCountToday").text(resp.response.stockRefils);
    }, "json");
}

function orderAmountToday(){

    $.post(base_url + "/System/Dashboard/orderAmountToday", "", function(){

        $("#orderAmountToday").text(resp.response.stockRefils);
    }, "json");
}

function orderAllDatInWeek(){

    $.post(base_url + "/System/Dashboard/orderAllDayInWeek", "", function(){

        // Chart implement here
    });
}

function fanshineTree(){

    $.post(base_url + "/System/Dashboard/fanshineTree", "", function(){

    });
}
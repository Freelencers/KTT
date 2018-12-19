// on load
payCount();
shippingOrder();
newFanshine();
stockRefils();
orderCount();
orderAmountToday();
orderAllDatInWeek();

// on aciton

$.post(base_url + "/System/Dashboard/fanshineTree", {}, function(resp){
    var contex_menu = {};
    tree = createTree('div_tree','white',contex_menu);
    
    var root = tree.createNode( "Gatatong" ,true,'/assets/aimaraJS/images/star.png',null,null,'context1');
    travelInTree(root, resp);
    tree.drawTree();
},"json");

// defination

function travelInTree(node, resp){

    var temp = "";
    for(var i=0;i<resp.child.length;i++){

        temp = node.createChildNode( resp.child[i].lv + " : " + resp.child[i].name ,true,'/assets/aimaraJS/images/person.png',null,null,'context1');
        travelInTree(temp, resp.child[i]);
    }
    return 0;
}

function payCount(){

    // https://api.myjson.com/bins/12hoto
    $.post(base_url + "/System/Dashboard/payCount", "", function(resp){

        $("#payCount").text(resp.response.payCount);
    }, "json");
}

function shippingOrder(){

    $.post(base_url + "/System/Dashboard/shippingCount", "", function(resp){

        $("#shippingCount").text(resp.response.shippingCount);
    }, "json");
}

function newFanshine(){

    $.post(base_url + "/System/Dashboard/newFanshineCount", "", function(resp){

        $("#newFanshineCount").text(resp.response.newFanshineCount);
    }, "json");
}

function stockRefils(){

    $.post(base_url + "/System/Dashboard/stockRefilsWarning", "", function(resp){

        $("#stockRefilsCount").text(resp.response.stockRefils);
    }, "json");
}

function orderCount(){

    $.post(base_url + "/System/Dashboard/orderCountToday", "", function(resp){

        $("#orderCount").text(resp.response.orderCountToday);
    }, "json");
}

function orderAmountToday(){

    $.post(base_url + "/System/Dashboard/orderAmountToday", "", function(resp){

        $("#orderAmount").text(resp.response.orderAmountToday);
    }, "json");
}

function orderAllDatInWeek(){

    $.post(base_url + "/System/Dashboard/orderAllDayInWeek", "", function(resp){

        // Chart implement here
        Highcharts.chart('containerLineChart', {

            title: {
                text: ''
            },
            
            subtitle: {
                text: ''
            },
            exporting: {
                enabled: false
            },
            yAxis: {
                title: {
                    text: 'Order Value'
                }
            },

            xAxis: {
                categories: resp.response.categories
            },
            series: [{
                name: resp.series.name,
                data: resp.series.data
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }
            
        });
    }, "json");
}


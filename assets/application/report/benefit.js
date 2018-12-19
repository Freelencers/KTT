// On load

loadChart();

// on action
$(".filter").change(function(){

    loadChart();
});
// defination

function loadChart(){
    var costBy = "";
    var costByExpense = false;
    var costByProduct = false;

    $(".costBy").each(function(elem){

        if(this.checked){

            costBy = $(this).val();
        }
    });

    switch(costBy){
        case "costByExpense" : costByExpense = true;
                               $("#includeWaitPayFrame").hide();
                               break;
        case "costByProduct" : costByProduct = true;
                               $("#includeWaitPayFrame").show();
                               break;
    }

    var json = {
        "costByProduct" : costByProduct,
        "costByExpense" : costByExpense,
        "includeWaitPay" : $("#includeWaiting").is( ":checked" ),
        "year" : $("#filterYear").val()
    }
    $.post(base_url + "/Report/Benefit/getBenefit", json, function(resp){

        Highcharts.chart('container', {

            title: {
                text: 'Benefit'
            },

            subtitle: {
                text: 'Source: thesolarfoundation.com'
            },

            yAxis: {
                title: {
                    text: 'Number of Employees'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            plotOptions: {
                series: {
                    label: {
                        connectorAllowed: false
                    },
                    pointStart: 2010
                }
            },

            series: [{
                name: resp[0].name,
                data: resp[0].data 
            }, {
                name: resp[1].name,
                data: resp[1].data 
            }, {
                name: resp[2].name,
                data: resp[2].data 
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
    },"json");
}



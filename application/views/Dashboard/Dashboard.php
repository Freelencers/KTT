<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        <?=$pageTitle?> 
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-ship"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text"><?=$shippingCount;?></span>
                    <span class="info-box-number" id="shippingCount">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text"><?=$payCount;?></span>
                    <span class="info-box-number" id="payCount">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-group"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text"><?=$newFanshineCount;?></span>
                    <span class="info-box-number" id="newFanshineCount">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-plus-square"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text"><?=$stockRefilsCount;?></span>
                    <span class="info-box-number" id="stockRefilsCount">0</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                    <i class="fa fa-group"></i>

                    <h3 class="box-title"><?=$fanshineTree?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="div_tree"></div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
                    <i class="fa fa-reorder"></i>

                    <h3 class="box-title"><?=$orderToday?></h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="small-box bg-yellow">
                                    <div class="inner">
                                        <h3 id="orderAmount">0</h3>
                                        <p><?=$orderAmount?></p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-money"></i>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h3 id="orderCount">0</h3>
                                        <p><?=$orderCount?></p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>    
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <div id="containerLineChart"></div>
                            </div>
                        </div>         



                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- Load js file -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<!-- tree lib -->
<link rel="stylesheet" href="<?=base_url("/assets/aimaraJS/")?>css/Aimara.css">
<script src="<?=base_url("/assets/aimaraJS/")?>lib/Aimara.js"></script>

<script>

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
    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri']
},
series: [{
    name: 'Amount',
    data: [43934, 52503, 57177, 69658, 97031]
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
</script>

<script>
var contex_menu = {};

tree = createTree('div_tree','white',contex_menu);

//Loop to create test nodes
for (var i=1; i<10; i++) {
    node1 = tree.createNode('Level 0 - Node ' + i,false,base_url+'assets/aimaraJS/images/star.png',null,null,'context1');
    for (var j=1; j<5; j++) {
        node2 = node1.createChildNode('Level 1 - Node ' + j, false, base_url+'assets/aimaraJS/images/blue_key.png',null,'context1');
        for (var k=1; k<5; k++) {
            node3 = node2.createChildNode('Level 2 - Node ' + k, false, base_url+'assets/aimaraJS/images/monitor.png',null,'context1');
            /*for (var l=1; l<5; l++) {
                node4 = node3.createChildNode('Level 3 - Node ' + l, false, 'images/key_green.png',null,'context1');
                for (var m=1; m<5; m++) {
                    node4.createChildNode('Level 4 - Node ' + m, false, 'images/file.png',null,'context1');
                }
            }*/
        }
    }
}

tree.drawTree();
</script>
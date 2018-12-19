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
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
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$filterTitle?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="form-control filter" id="filterYear">
                                    <option value="<?=date('Y')?>"><?=date("Y") + 543?></option>
                                    <option value="<?=date('Y') - 1?>"><?=date("Y") + 542?></option>
                                    <option value="<?=date('Y') - 2 ?>"><?=date("Y") + 541?></option>
                                    <option value="<?=date('Y') - 3?>"><?=date("Y") + 540?></option>
                                    <option value="<?=date('Y') - 4?>"><?=date("Y") + 539?></option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" class="costBy filter" name="cost" value="costByProduct" checked="checked" style="margin-right: 6px"><?=$costByProduct?> 
                                    </label>
                               </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" class="costBy filter" name="cost" value="costByExpense" style="margin-right: 6px"><?=$costByExpense?> 
                                    </label>
                               </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row" id="includeWaitPayFrame">
                            <div class="col-md-12">
                                <div class="checkbox" style="margin-left: 20px">
                                    <label>
                                        <input type="checkbox" class="filter" id="includeWaiting"><?=$includeWaiting?> 
                                    </label>
                               </div>
                            </div>
                        </div>                        
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-8">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=$filterTitle?></h3>
                </div>
                <div class="box-body">
                <div id="container"></div>
                </div>
                <!-- /.box-body -->
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


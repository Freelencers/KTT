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
            <div class="col-md-3">
                <div class="info-box bg-yellow">
                    <span class="info-box-icon"><i class="fa fa-cubes"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text"><?=$refilsTitle?></span>
                    <h1><span class="info-box-number" id="stockRefils"></span></h1>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                        <span class="progress-description">
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-9">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$filterTitle?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" id="search" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox" class="stockCondition" condition="OUTOF-ACTUAL-STOCK">
                                        <?=$outOfStock?> 
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox" class="stockCondition" condition="OUTOF-VIRTUAL-STOCK">
                                        <?=$outOfActualStock?> 
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox" class="stockCondition" condition="REFILS-ACTUAL-STOCK">
                                        <?=$refilsOfStock?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox" class="stockCondition" condition="REFILS-ACTUAL-STOCK">
                                        <?=$refilsOfActialStock?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="active tabs" tabName="STOCK"><a href="#tab_1" data-toggle="tab">Stock</a></li>
                    <li class="tabs" tabName="HISTORY"><a href="#tab_2" data-toggle="tab">History</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <table class="template" id="rowTemplate">
                                <tbody>
                                        <tr class="{hightLight}" >
                                            <td>{no}</td>
                                            <td>{matCode}</td>
                                            <td>{matName}</td>
                                            <td>{matType}</td>
                                            <td>{stoActualStock}</td>
                                            <td>{stoVirtualStock}</td>
                                            <td>
                                                <span class="m-4 badge bg-blue pointer inputStock" matId="{matId}"><?=$stockIn?></span>
                                                <span class="m-4 badge bg-blue pointer outputStock" matId="{matId}"><?=$stockOut?></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <table class="table table-bordered table-hover dataTable">
                                <thead>
                                    <th><?=$no?></th>
                                    <th><?=$sku?></th>
                                    <th><?=$productName?></th>
                                    <th><?=$type?></th>
                                    <th><?=$actualStock?></th>
                                    <th><?=$stock?></th>
                                    <th><?=$action?></th>
                                </thead>
                                <tbody id="tableStockList">
                                  
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <div class="template" id="inputStockLabel">
                                <span class="badge bg-green" ><?=$stockIn?></span>
                            </div>
                            <div class="template" id="outputStockLabel">
                                <span class="badge bg-red"><?=$stockOut?></span>
                            </div>
                            <table class="template" id="rowTemplateHistory">
                                <tbody>
                                        <tr>
                                            <td>{no}</td>
                                            <td>{matCode}</td>
                                            <td>{matName}</td>
                                            <td>{matType}</td>
                                            <td>{locName}</td>
                                            <td>{shtActionDate}</td>
                                            <td>{shtAmount}</td>
                                            <td>{stoCost}</td>
                                            <td>{shtTotal}</td>
                                            <td>{shtType}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            <table class="table table-bordered table-hover dataTable">
                            <thead>
                                    <th><?=$no?></th>
                                    <th><?=$sku?></th>
                                    <th><?=$productName?></th>
                                    <th><?=$type?></th>
                                    <th><?=$location?></th>
                                    <th><?=$actionTime?></th>
                                    <th><?=$amount?></th>
                                    <th><?=$cost?></th>
                                    <th><?=$total?></th>
                                    <th><?=$stockAction?></th>
                                </thead>
                                <tbody id="tableStockHistoryList">
                                   
                                </tbody>
                            </table>

                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                    <div class="col-md-12">
                        <ul class="pagination paginationList pull-right">
                          
                        </ul>
                    </div>
                </div>            
            </div>
            <!-- Custom Tabs -->
        </div>
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-inputStock" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-block btn-lg btn-success"><?=$stockIn?></button>
                    </div>
                </div>
                <br>
                <div class="row pt-5">
                    <div class="col-md-12">
                        <form role="form" id="inputStockForm">
                            <!-- text input -->
                            <div class="form-group">
                                <label><?=$sku?></label>
                                <input type="text" class="form-control matCode disabled autoGet" id="matCode" disabled>
                            </div>
                            <div class="form-group">
                                <label><?=$productName?></label>
                                <input type="text" class="form-control matName autoGet disabled" id="matName" disabled>
                            </div>
                            <div class="form-group">
                                <label><?=$amount?></label>
                                <input type="text" class="form-control autoGet matAmount" id="matAmount" type="number">
                            </div>
                            <div class="form-group">
                                <label><?=$cost?></label>
                                <input type="text" class="form-control autoGet matCost" id="matCost" type="number">
                            </div>
                            <div class="form-group">
                                <label><?=$location?></label>
                                <select class="form-control autoGet" id="matLocId">
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?=$expire?></label>
                                <input type="text" class="form-control autoGet datepicker" id="matExpDate">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$close?></button>
                <button type="button" class="btn btn-primary" id="actionInputStock"><?=$save?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-outputStock" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-block btn-lg btn-maroon bg-maroon"><?=$stockOut?></button>
                    </div>
                </div>
                <br>
                <div class="row pt-5">
                    <div class="col-md-12">
                        <form role="form" id="outputStockForm">
                            <!-- text input -->
                            <div class="form-group">
                                <label><?=$sku?></label>
                                <input type="text" class="form-control matCode autoGet" id="matCode" disabled>
                            </div>
                            <div class="form-group">
                                <label><?=$productName?></label>
                                <input type="text" class="form-control matName autoGet disabled" id="matName" disabled>
                            </div>
                            <div class="form-group">
                                <label><?=$amount?></label>
                                <input type="text" class="form-control autoGet matAmount" id="matAmount" type="number">
                            </div>
                            <div class="form-group">
                                <label><?=$location?></label>
                                <select class="form-control autoGet matLocStock" id="matLocId">
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$close?></button>
                <button type="button" class="btn btn-primary" id="actionOutputStock"><?=$save?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
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
                    <span class="info-box-number" id="refilsCount"></span>

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
                                <input type="text" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox">
                                        <?=$outOfStock?> 
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox">
                                        <?=$outOfActualStock?> 
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox">
                                        <?=$refilsOfStock?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="checkbox">
                                    <label>
                                    <input type="checkbox">
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
                    <li class="active"><a href="#tab_1" data-toggle="tab">Stock</a></li>
                    <li><a href="#tab_2" data-toggle="tab">History</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
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
                                <tbody>
                                    <tr id="stockColumnTemplate">
                                        <td>{no}</td>
                                        <td>{sku}</td>
                                        <td>{productName}</td>
                                        <td>{type}</td>
                                        <td>{actualStock}</td>
                                        <td>{stock}</td>
                                        <td>
                                            <i class="fa fa-fw fa-exchange" data-toggle="modal" data-target="#modal-stock" data-accId="{proId}"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
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
                                <tbody>
                                    <tr id="stockColumnTemplate">
                                        <td>{no}</td>
                                        <td>{sku}</td>
                                        <td>{productName}</td>
                                        <td>{type}</td>
                                        <td>{location}</td>
                                        <td>{time}</td>
                                        <td>{amount}</td>
                                        <td>{cost}</td>
                                        <td>{total}</td>
                                        <td>
                                            <span class="pull-right badge bg-green"><?=$stockIn?></span>
                                            <span class="pull-right badge bg-red"><?=$stockOut?></span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                    <div class="col-md-12">
                        <ul class="pagination pull-right">
                            <li class="paginate_button">
                                <a href="#">1</a>
                            </li>
                            <li class="paginate_button active">
                                <a href="#">1</a>
                            </li>
                            <li class="paginate_button ">
                                <a href="#">1</a>
                            </li>
                            <li class="paginate_button">
                                <a href="#">1</a>
                            </li>
                        </ul>
                    </div>
                </div>            
            </div>
            <!-- Custom Tabs -->
        </div>
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-stock" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-block btn-lg btn-success">IN</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-block btn-lg btn-danger">OUT</button>
                    </div>
                </div>
                <br>
                <div class="row pt-5">
                    <div class="col-md-12">
                        <form role="form">
                            <!-- text input -->
                            <div class="form-group">
                                <label><?=$sku?></label>
                                <input type="text" class="form-control" id="locName">
                            </div>
                            <div class="form-group">
                                <label><?=$productName?></label>
                                <select class="form-control" id="proLocId">
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?=$amount?></label>
                                <select class="form-control" id="proUntId">
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?=$cost?></label>
                                <select class="form-control" id="proType">
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?=$location?></label>
                                <input type="text" class="form-control" id="proMin">
                            </div>
                            <div class="form-group">
                                <label><?=$expire?></label>
                                <input type="text" class="form-control" id="proMax">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$close?></button>
                <button type="button" class="btn btn-primary" id="modalSaveButton"><?=$save?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
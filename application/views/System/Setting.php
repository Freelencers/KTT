<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        <?=$pageTitle?> 
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$defaultSetting?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group">
                            <label><?=$moneyToPoint?></label>
                            <input type="text" class="form-control" id="accFirstname">
                        </div>
                        <div class="form-group">
                            <label><?=$tax?></label>
                            <input type="text" class="form-control" id="accLastname">
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group">
                            <label><?=$pointToMoney?></label>
                            <input type="text" class="form-control" id="accFirstname">
                        </div>
                        <div class="form-group">
                            <label><?=$standardPoint?></label>
                            <input type="text" class="form-control" id="accLastname">
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                <?=$memberFee?>
                            </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="box-body">
                                <form role="form">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Level S</label>
                                        <input type="text" class="form-control" id="accFirstname">
                                    </div>
                                    <div class="form-group">
                                        <label>Level M</label>
                                        <input type="text" class="form-control" id="accLastname">
                                    </div>
                                    <div class="form-group">
                                        <label>Level L</label>
                                        <input type="text" class="form-control" id="accLastname">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                <?=$specialCondition?>
                            </a>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="box-body">
                                <form role="form">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label><?=$pounderWeight?></label>
                                        <input type="text" class="form-control" id="accFirstname">
                                    </div>
                                    <div class="form-group">
                                        <label><?=$commission?></label>
                                        <input type="text" class="form-control" id="accLastname">
                                    </div>
                                    <div class="form-group">
                                        <label><?=$refer?></label>
                                        <input type="text" class="form-control" id="accLastname">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer-->
        </div>
        <!-- /.box -->

        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab"><?=$schedule?></a></li>
                        <li><a href="#tab_2" data-toggle="tab"><?=$history?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <th><?=$date?></th>
                                    <th><?=$moneyToPoint?></th>
                                    <th><?=$pointToMoney?></th>
                                    <th><?=$tax?></th>
                                    <th>S</th>
                                    <th>M</th>
                                    <th>L</th>
                                    <th><?=$pounderWeight?></th>
                                    <th><?=$commission?></th>
                                    <th><?=$refer?></th>
                                    <th><?=$standardPoint?></th>
                                    <th><?=$action?></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{date}</td>
                                        <td>{moneyToPoint}</td>
                                        <td>{pointToMoney}</td>
                                        <td>{tax}</td>
                                        <td>{s}</td>
                                        <td>{m}</td>
                                        <td>{l}</td>
                                        <td>{pounderWeight}</td>
                                        <td>{commission}</td>
                                        <td>{refer}</td>
                                        <td>{standardPoint}</td>
                                        <td>
                                            <i class="fa fa-fw fa-edit" data-ssgId="{ssgId}"></i>
                                            <i class="fa fa-fw fa-trash" onclick="deleteConfirmBox({ssgId})"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                        <table class="table table-bordered table-hover">
                                <thead>
                                    <th><?=$date?></th>
                                    <th><?=$moneyToPoint?></th>
                                    <th><?=$pointToMoney?></th>
                                    <th><?=$tax?></th>
                                    <th>S</th>
                                    <th>M</th>
                                    <th>L</th>
                                    <th><?=$pounderWeight?></th>
                                    <th><?=$commission?></th>
                                    <th><?=$refer?></th>
                                    <th><?=$standardPoint?></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{date}</td>
                                        <td>{moneyToPoint}</td>
                                        <td>{pointToMoney}</td>
                                        <td>{tax}</td>
                                        <td>{s}</td>
                                        <td>{m}</td>
                                        <td>{l}</td>
                                        <td>{pounderWeight}</td>
                                        <td>{commission}</td>
                                        <td>{refer}</td>
                                        <td>{standardPoint}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
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
                    <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text"><?=$commissionTime?></span>
                    <span class="info-box-number" id="commissionTime"></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                        <span class="progress-description">
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box bg-green">
                    <span class="info-box-icon"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                    <span class="info-box-text"><?=$commissionAmount?></span>
                    <span class="info-box-number" id="commissionAmount"></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                        <span class="progress-description">
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$filterTitle?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <select class="form-control">
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control">
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-3">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$searchTitle?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div><!-- row -->
        <div class="row">
            <div class="col-md-3">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$cycleReport?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th><?=$cycleDate?></th>
                                        <th><?=$action?></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{cmrDate}</td>
                                            <td>
                                                <i class="fa fa-fw fa-bank" data-cmrId="{cmrId}"></i>
                                                <i class="fa fa-fw fa-file-text" data-cmrId="{cmrId}"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                    <!-- /.box-body -->
                </div>
            </div>

            <!-- Commission Table -->
            <div class="col-md-9">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$cycleReport?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th><?=$code?></th>
                                        <th><?=$name?></th>
                                        <th><?=$bank?></th>
                                        <th><?=$bankAccount?></th>
                                        <th><?=$privatePoint?></th>
                                        <th><?=$companyPoint?></th>
                                        <th><?=$amount?></th>
                                        <th><?=$commission?></th>
                                        <th><?=$action?></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{code}</td>
                                            <td>{FanshineName}</td>
                                            <td>{bank}</td>
                                            <td>{bankAccount}</td>
                                            <td>{privatePoint}</td>
                                            <td>{companyPoint}</td>
                                            <td>{amount}</td>
                                            <td>{commission}</td>
                                            <td>
                                                <i class="fa fa-fw fa-file-text" data-cmrId="{cmrId}"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        
    </section>
    <!-- /.content -->
</div>
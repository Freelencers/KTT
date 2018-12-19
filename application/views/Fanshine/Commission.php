
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
                                <select class="form-control filter" id="filterColumn">
                                    <option value="cmsTotalPrivatePoint"><?=$privatePoint?></option>
                                    <option value="cmsTotalPublicPoint"><?=$companyPoint?></option>
                                    <option value="cmsTotalPoint"><?=$amount?></option>
                                    <option value="cmsTotalCommission"><?=$commission?></option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control filter" id="filterCondition">
                                    <option value=">"> > </option>
                                    <option value="<"> < </option>
                                    <option value="="> = </option>
                                    <option value=">="> >= </option>
                                    <option value="<="> <= </option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control filter" id="filterValue">
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
                                <input type="text" class="form-control filter" id="search">
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
                                <!-- template -->
                                <table class="template" id="rowTemplateReport">
                                    <tbody>
                                        <tr>
                                            <td>{cmrDate}</td>
                                            <td>
                                                <i class="fa fa-fw fa-bank pointer generatePdfTransfer" cmrId="{cmrId}"></i>
                                                <i class="fa fa-fw fa-file-text pointer getReportDetail" cmrId="{cmrId}"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th><?=$cycleDate?></th>
                                        <th><?=$action?></th>
                                    </thead>
                                    <tbody id="tbodyReportList">

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <ul class="pagination paginationReportList pull-right pagination-sm no-margin">
                                
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
                                <!-- template -->
                                <table class="template" id="rowTemplateCommission">
                                    <tbody>
                                        <tr>
                                            <td>{code}</td>
                                            <td>{fanshineName}</td>
                                            <td>{bank}</td>
                                            <td>{bankAccount}</td>
                                            <td>{privatePoint}</td>
                                            <td>{companyPoint}</td>
                                            <td>{amount}</td>
                                            <td>{commission}</td>
                                            <td>
                                                <i class="fa fa-fw fa-file-text pointer generateCommissionDetailPdf" cmsCmrId="{cmsCmrId}" cmsCusId="{cmsCusId}"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> 
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
                                    <tbody id="tbodyCommissionList">
                                    
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12">
                                <ul class="pagination paginationCommissionList pull-right">
                                
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
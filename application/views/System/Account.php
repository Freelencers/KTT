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
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-2 pull-right">
                                <button type="button" class="btn btn-block btn-primary" id="createNewAcountButtom"><?=$createNewAccount?></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- template -->
                        <table class="template" id="rowTemplate">
                            <tbody>
                                <tr> 
                                    <td>{no}</td>
                                    <td>{accFirstname}</td>
                                    <td>{accLastname}</td>
                                    <td>{accUsername}</td>
                                    <td>{accCreatedate}</td>
                                    <td>
                                        <i class="fa fa-fw fa-edit updateAccount pointer" accId="{accId}"></i>
                                        <i class="fa fa-fw fa-trash pointer" onclick="deleteConfirmBox({accId})"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$no?></th>
                                <th><?=$firstname?></th>
                                <th><?=$lastname?></th>
                                <th><?=$username?></th>
                                <th><?=$registerDate?></th>
                                <th><?=$action?></th>
                            </thead>
                            <tbody id="tbodyAccountList">
                                <!-- append here -->
                            </tbody>
                        </table>
                        <div class="col-md-12">
                            <ul class="pagination paginationList pull-right">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<div class="modal fade" id="modal-createNewAccount" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="createNewAccountForm">
                    <!-- text input -->
                    <div class="form-group">
                        <label><?=$firstname?></label>
                        <input type="text" class="form-control autoGet validate" require="true" id="accFirstname">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label><?=$lastname?></label>
                        <input type="text" class="form-control autoGet validate" require="true" id="accLastname">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label><?=$username?></label>
                        <input type="text" class="form-control autoGet validate" require="true" id="accUsername">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label><?=$password?></label>
                        <input type="password" class="form-control autoGet validate" require="true" id="accPassword">
                        <span class="help-block"></span>
                    </div>
                </form>
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
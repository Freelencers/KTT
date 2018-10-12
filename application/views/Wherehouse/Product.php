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
                                <button type="button" class="btn btn-block btn-primary" id="createNewAcountButtom" data-toggle="modal" data-target="#modal-createNewAccount"><?=$createNewProduct?></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$no?></th>
                                <th><?=$sku?></th>
                                <th><?=$productName?></th>
                                <th><?=$location?></th>
                                <th><?=$unit?></th>
                                <th><?=$min?></th>
                                <th><?=$max?></th>
                                <th><?=$action?></th>
                            </thead>
                            <tbody>
                                <tr id="locationColumnTemplate">
                                    <td>{no}</td>
                                    <td>{proCode}</td>
                                    <td>{proName}</td>
                                    <td>{locName}</td>
                                    <td>{untName}</td>
                                    <td>{proMin}</td>
                                    <td>{proMax}</td>
                                    <td>
                                        <i class="fa fa-fw fa-edit" data-accId="{proId}"></i>
                                        <i class="fa fa-fw fa-trash" onclick="deleteConfirmBox({proId})"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                <form role="form">
                    <!-- text input -->
                    <div class="form-group">
                        <label><?=$productName?></label>
                        <input type="text" class="form-control" id="locName">
                    </div>
                    <div class="form-group">
                        <label><?=$location?></label>
                        <select class="form-control" id="proLocId">
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?=$unit?></label>
                        <select class="form-control" id="proUntId">
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?=$type?></label>
                        <select class="form-control" id="proType">
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?=$min?></label>
                        <input type="text" class="form-control" id="proMin">
                    </div>
                    <div class="form-group">
                        <label><?=$max?></label>
                        <input type="text" class="form-control" id="proMax">
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
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
                                <button type="button" class="btn btn-block btn-primary" id="createLocatinoButton"><?=$createNewLocation?></button>
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
                                    <td>{locName}</td>
                                    <td>{locDescription}</td>
                                    <td>
                                        <i class="fa fa-fw fa-edit pointer changeLocationDetail" locId="{locId}"></i>
                                        <i class="fa fa-fw fa-trash pointer" onclick="deleteConfirmBox({locId})"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$no?></th>
                                <th><?=$name?></th>
                                <th><?=$description?></th>
                                <th><?=$action?></th>
                            </thead>
                            <tbody>
                                <tbody id="tbodyAccountList">
                                    <!-- append here -->
                                </tbody>
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

<div class="modal fade" id="modal-createNewLocation" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="locationForm">
                    <!-- text input -->
                    <div class="form-group">
                        <label><?=$name?></label>
                        <input type="text" class="form-control autoGet" id="locName">
                    </div>
                    <div class="form-group">
                        <label><?=$description?></label>
                        <textarea class="form-control autoGet" id="locDetail">
                        </textarea>
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
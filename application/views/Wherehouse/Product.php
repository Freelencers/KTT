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
                                <button type="button" class="btn btn-block btn-primary" id="createNewProductButton" data-toggle="modal" data-target="#modal-createNewAccount"><?=$createNewProduct?></button>
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
                                    <td>{matCode}</td>
                                    <td>{matName}</td>
                                    <td>{matType}</td>
                                    <td>{locName}</td>
                                    <td>{untName}</td>
                                    <td>{matMin}</td>
                                    <td>{matMax}</td>
                                    <td>
                                        <i class="fa fa-fw fa-edit changMaterialDetail pointer" matId="{matId}"></i>
                                        <i class="fa fa-fw fa-trash pointer" onclick="deleteConfirmBox({matId})"></i>
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
                                <th><?=$location?></th>
                                <th><?=$unit?></th>
                                <th><?=$min?></th>
                                <th><?=$max?></th>
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

<div class="modal fade" id="modal-createNewProduct" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="materialForm">
                    <!-- text input -->
                    <div class="form-group">
                        <label><?=$productName?></label>
                        <input type="text" class="form-control autoGet validate" require="true" id="matName">
                    </div>
                    <div class="form-group">
                        <label><?=$location?></label>
                        <select class="form-control autoGet validate" require="true" id="matLocId">
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?=$unit?></label>
                        <select class="form-control autoGet validate" require="true" id="matUntId">
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?=$type?></label>
                        <select class="form-control autoGet validate" require="true" id="matType">
                            <option value="MATERIAL"><?=$this->lang->line("wherehouseProductMaterial");?></option>
                            <option value="PRODUCT"><?=$this->lang->line("wherehouseProductProduct");?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><?=$min?></label>
                        <input type="text" class="form-control autoGet validate" require="true" id="matMin">
                    </div>
                    <div class="form-group">
                        <label><?=$max?></label>
                        <input type="text" class="form-control autoGet validate" require="true" id="matMax">
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
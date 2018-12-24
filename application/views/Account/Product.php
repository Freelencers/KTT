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
                                    <td>{prdMatCode}</td>
                                    <td>{prdMatName}</td>
                                    <td>
                                        <i class="fa fa-fw fa-edit pointer changProductDetail" prdId="{prdId}"></i>
                                        <i class="fa fa-fw fa-trash pointer" onclick="deleteConfirmBox({prdId})"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$no?></th>
                                <th><?=$sku?></th>
                                <th><?=$productName?></th>
                                <th><?=$action?></th>
                            </thead>
                            <tbody id="tbodyProductList">
                                
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
                <form role="form" >
                    <!-- text input -->
                    <div id="productForm">
                        <div class="form-group" >
                            <div class="form-group" id="showMatName">
                                <label><?=$productName?></label>
                                <input type="text" class="form-control autoGet" require="true" id="matName" disabled>
                                <span class="help-block"></span>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label><?=$price?></label>
                                    <input type="number" class="form-control autoGet validate" require="true" min="0" id="prdFullPrice">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <label><?=$discount?></label>
                                    <input type="number" class="form-control autoGet validate" require="true" min="0" id="prdDiscount">
                                    <span class="help-block"></span>
                                </div>
                                <div class="col-md-4">
                                    <label><?=$total?></label>
                                    <input type="number" class="form-control autoGet validate" require="true" min="0" id="prdTotal">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><?=$point?></label>
                            <input type="number" class="form-control autoGet validate" require="true" min="0" id="prdPoint">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    
                    <div class="form-group" id="materialTable">
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <input class="form-control" type="text" placeholder="Search" id="searchMaterial">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">

                                <!-- template -->
                                <table class="template" id="materialTemplate">
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" class="autoGet matIdRadio" name="matId"  value="{matId}" {checked}></td>
                                            <td>{matCode}</td>
                                            <td>{matName}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered table-hover pb-0">
                                    <thead>
                                        <th><input type="radio" disabled></th>
                                        <th><?=$sku?></th>
                                        <th><?=$productName?></th>
                                    </thead>
                                    <tbody id="tbodyMatarialList">
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 m-0 p-0">
                                <ul class="pagination pagination-sm no-margin paginationMaterialList pull-right">
                                  
                                </ul>
                            </div>
                        </div>
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
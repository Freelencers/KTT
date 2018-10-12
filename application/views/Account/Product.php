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
                                <th><?=$action?></th>
                            </thead>
                            <tbody>
                                <tr id="locationColumnTemplate">
                                    <td>{no}</td>
                                    <td>{proCode}</td>
                                    <td>{proName}</td>
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
                        <input type="text" class="form-control" id="prdName">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label><?=$price?></label>
                                <input type="text" class="form-control" id="prdPrice">
                            </div>
                            <div class="col-md-4">
                                <label><?=$discount?></label>
                                <input type="text" class="form-control" id="prdDiscount">
                            </div>
                            <div class="col-md-4">
                                <label></label>
                                <input type="text" class="form-control" id="prdTotal">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><?=$point?></label>
                        <input type="text" class="form-control" id="prdPoint">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <input type="text" placeholder="Search" id="searchKeyword">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <th><input type="radio"></th>
                                        <th><?=$sku?></th>
                                        <th><?=$productName?></th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="radio" name="productId" value="{prdId}"></td>
                                            <td>{sku}</td>
                                            <td>{productName}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
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
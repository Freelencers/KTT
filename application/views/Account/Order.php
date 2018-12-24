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
                                <a href="<?= base_url("/index.php/Font-end/Account/Order/createOrder"); ?>">
                                    <button type="button" class="btn btn-block btn-primary"> <?=$createNewOrder?></button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <!-- template -->
                        <table class="template" id="orderTemplate">
                            <tbody>
                                <tr>
                                    <td>{ordCreatedate}</td>
                                    <td>{ordCode}</td>
                                    <td>{cusFullName}</td>
                                    <td>{ordTotal}</td>
                                    <td>{ordStatus}</td>
                                    <td>
                                        <i class="fa fa-fw fa-edit pointer changeOrder hide" ordId="{ordId}"></i>
                                        <i class="fa fa-fw fa-trash pointer {hideRemoveIcon}" onclick="deleteConfirmBox({ordId})"></i>
                                        <i class="fa fa-fw fa-mail-forward pointer nextStatus" ordId="{ordId}"></i> 
                                        <i class="fa fa-fw fa-print pointer buttonGeneratePDF" ordId="{ordId}"></i> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$date?></th>
                                <th><?=$code?></th>
                                <th><?=$fanshineName?></th>
                                <th><?=$amount?></th>
                                <th><?=$status?></th>
                                <th><?=$action?></th>
                            </thead>
                            <tbody id="tbodyOrderList">
                                
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


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

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- Template -->
                        <table class="template" id="orderTemplate">
                            <tbody>
                                <tr>
                                    <td>{date}</td>
                                    <td>{orderCode}</td>
                                    <td>{fanshineName}</td>
                                    <td>{amount}</td>
                                    <td>{status}</td>
                                    <td>
                                        <i class="fa fa-fw fa-file-text buttonGeneratePDF pointer" ordId="{ordId}"></i>
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


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
                                <button type="button" class="btn btn-block btn-primary" id="createNewAcountButtom" data-toggle="modal" data-target="#modal-createNewAccount"><?=$createNewOrder?></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$date?></th>
                                <th><?=$code?></th>
                                <th><?=$fanshineName?></th>
                                <th><?=$amount?></th>
                                <th><?=$status?></th>
                                <th><?=$action?></th>
                            </thead>
                            <tbody>
                                <tr id="locationColumnTemplate">
                                    <td>{date}</td>
                                    <td>{orderId}</td>
                                    <td>{fanshineName}</td>
                                    <td>{amount}</td>
                                    <td>{status}</td>
                                    <td>
                                        <i class="fa fa-fw fa-edit" data-ordId="{ordId}"></i>
                                        <i class="fa fa-fw fa-trash" onclick="deleteConfirmBox({ordId})"></i>
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


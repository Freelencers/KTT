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
                                <tr class="template">
                                    <td>{no}</td>
                                    <td>{accFirstname}</td>
                                    <td>{accLastname}</td>
                                    <td>{accUsername}</td>
                                    <td>{accCreatedate}</td>
                                    <td>
                                        <i class="fa fa-fw fa-lock permissionModal" data-accId="{accId}"></i>
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

<div class="modal fade" id="modal-permissionSetting" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
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
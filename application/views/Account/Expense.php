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
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$expenseToday?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-primary" id=""><?=$income?> : <span id="incomeAmount"></span></button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-primary" id=""><?=$outcome?> : <span id="expenseAmount"></span></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$filterTitle?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker search" placeholder="Start Date" id="startDate">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker search" placeholder="End Date" id="endDate">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control search" id="type">
                                    <option value="BOTH">All</option>
                                    <option value="INCOME"><?=$income?></option>
                                    <option value="EXPENSE"><?=$outcome?></option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control search" placeholder="Search" id="search">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?=$createNewExpense?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-primary createNewExpense" epnType="INCOME"><?=$income?></button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-primary createNewExpense" epnType="EXPENSE"><?=$outcome?></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="template" id="expenseTemplate">
                            <tbody>
                                <tr>
                                    <td>{date}</td>
                                    <td>{title}</td>
                                    <td>{detail}</td>
                                    <td>{type}</td>
                                    <td>{amount}</td>
                                    <td>
                                        <i class="fa fa-fw fa-trash pointer" onclick="deleteConfirmBox({epnId})"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$date?></th>
                                <th><?=$title?></th>
                                <th><?=$detail?></th>
                                <th><?=$type?></th>
                                <th><?=$amount?></th>
                                <th><?=$action?></th>
                            </thead>
                            <tbody id="tbodyList">

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

<div class="modal fade" id="modal-createNewExpense" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$modalTitle?></h4>
            </div>
            <div class="modal-body" id="expenseForm">
                <form role="form" id="locationForm">
                    <!-- text input -->
                    <div class="form-group">
                        <label><?=$type?></label>
                        <input type="text" class="form-control autoGet validate" require="true" id="epnType" disabled>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label><?=$title?></label>
                        <input type="text" class="form-control autoGet validate" require="true" id="epnTitle">
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label><?=$detail?></label>
                        <textarea class="form-control autoGet validate" require="true" id="epnDetail"></textarea>
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label><?=$amount?></label>
                        <input type="number" class="form-control autoGet validate" require="true" id="epnAmount">
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


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
                                <button type="button" class="btn btn-block btn-primary" id=""><?=$income?></button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-primary" id=""><?=$outcome?></button>
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
                                <select class="form-control">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control">
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control">
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
                                <button type="button" class="btn btn-block btn-primary" id=""><?=$income?></button>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-block btn-primary" id=""><?=$outcome?></button>
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
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$date?></th>
                                <th><?=$title?></th>
                                <th><?=$detail?></th>
                                <th><?=$type?></th>
                                <th><?=$amount?></th>
                                <th><?=$action?></th>
                            </thead>
                            <tbody>
                                <tr id="locationColumnTemplate">
                                    <td>{date}</td>
                                    <td>{title}</td>
                                    <td>{detail}</td>
                                    <td>{type}</td>
                                    <td>{amount}</td>
                                    <td>
                                        <i class="fa fa-fw fa-file-text" data-ordId="{ordId}"></i>
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


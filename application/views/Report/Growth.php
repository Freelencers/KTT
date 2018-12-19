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
                        <!-- template -->
                        <table class="template" id="templateGrowth">
                            <tbody>
                                <tr>
                                    <td>{code}</td>
                                    <td>{fanshineName}</td>
                                    <td>{m1}</td>
                                    <td>{m2}</td>
                                    <td>{m3}</td>
                                    <td>{m4}</td>
                                    <td>{m5}</td>
                                    <td>{m6}</td>
                                    <td>{m7}</td>
                                    <td>{m8}</td>
                                    <td>{m9}</td>
                                    <td>{m10}</td>
                                    <td>{m11}</td>
                                    <td>{m12}</td>
                                    <td>{avg}</th>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$code?></th>
                                <th><?=$fanshineName?></th>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>
                                <th>6</th>
                                <th>7</th>
                                <th>8</th>
                                <th>9</th>
                                <th>10</th>
                                <th>11</th>
                                <th>12</th>
                                <th><?=$avg?></th>
                            </thead>
                            <tbody id="tableOfgrowth">
                            </tbody>
                        </table>
                        <div class="col-md-12 template">
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
                        <label><?=$name?></label>
                        <input type="text" class="form-control" id="locName">
                    </div>
                    <div class="form-group">
                        <label><?=$description?></label>
                        <textarea class="form-control" id="locDescription">
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
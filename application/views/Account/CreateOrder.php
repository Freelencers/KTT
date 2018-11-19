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
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?=$orderCreate?></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="form-group" id="customer">
                                    <label><?=$code?></label>
                                    <input type="text" class="form-control autoGet" id="matName" >
                                </div>
                                <div class="form-group" id="customer">
                                    <label><?=$customer?></label>
                                    <select class="form-control" id="cusCode">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?=$invoid?></h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row ">
                                    <div class="col-md-12">
                                        <button type="button" class="btn bg-info" style="width: 100%">
                                            <?=$point?>
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn bg-info" style="width: 100%">
                                            <?=$amount?>
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" class="btn bg-success" style="width: 100%">
                                            <?=$checkOut?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab"><?=$product?></a></li>
                    <li><a href="#tab_2" data-toggle="tab"><?=$myOrder?></a></li>
                    <li class="pull-right">
                        <div class="form-group margin" id="customer">
                            <input type="text" class="form-control autoGet" id="search" placeholder="search">
                        </div>
                    </li>
                    </ul>
                    <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-4">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{matName}</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <p><?=$code?>  : {code}</p>
                                            <p><?=$point?> : {point}</p>
                                            <p><?=$price?> : {price}</p>
                                            <p><?=$stock?> : {stock}</p>
                                        </div>
                                        <div class="box-footer with-border">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-block btn-danger btn-xs">-</button>
                                            </div>
                                            <div class="col-sm-3">
                                                <center>
                                                    <span class="amount">0</span>
                                                </center>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-block btn-success btn-xs">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <h3 class="box-title">{matName}</h3>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button type="button" class="btn btn-block btn-danger btn-xs">-</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <p><?=$code?>  : {code}</p>
                                            <p><?=$point?> : {point}</p>
                                            <p><?=$price?> : {price}</p>
                                            <p><?=$stock?> : {stock}</p>
                                        </div>
                                        <div class="box-footer with-border">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-block btn-danger btn-xs">-</button>
                                            </div>
                                            <div class="col-sm-3">
                                                <center>
                                                    <span class="amount">0</span>
                                                </center>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-block btn-success btn-xs">+</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><?=$invoid?></h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><?=$invoid?></h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="box box-solid">
                                        <div class="box-header with-border">
                                            <h3 class="box-title"><?=$invoid?></h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">

                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


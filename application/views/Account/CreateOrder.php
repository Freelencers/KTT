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
                                <div class="form-group" >
                                    <label><?=$searchCode?></label>
                                    <input type="text" class="form-control autoGet" id="searchCustomer" >
                                </div>
                                <div class="form-group" >
                                    <label><?=$customer?></label>
                                    <select class="form-control" id="customerList">
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
                                        <div class="btn bg-info" style="width: 100%">
                                            <?=$point?> : <span id="sumPoint">0</span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn bg-info" style="width: 100%">
                                            <?=$amount?> : <span id="sumPrice">0</span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="button" id="checkout" class="btn btn-block btn-success" style="width: 100%">
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

                        <!-- template -->
                        <div class="template" id="cardProductComponent">
                            <div class="col-md-4">
                                <div class="box box-solid box-primary">
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
                                            <button type="button" class="btn btn-block btn-danger btn-xs removeProductToCrat" prdId="{prdId}" action="remove">-</button>
                                        </div>
                                        <div class="col-sm-3">
                                            <center>
                                                <span class="amountOfProduct" prdId="{prdId}">0</span>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-block btn-success btn-xs addProductToCrat" prdId="{prdId}" action="add">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="template" id="cardMyProductCompenent">
                            <div class="col-md-4">
                                <div class="box box-solid box-primary">
                                    <div class="box-header with-border">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <h3 class="box-title">{matName}</h3>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-block btn-danger btn-xs removeOrder" prdId="{prdId}" sodId="{sodId}">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <p><?=$code?>  : {code}</p>
                                        <p><?=$point?> : {point}</p>
                                        <p><?=$price?> : {price}</p>
                                    </div>
                                    <div class="box-footer with-border">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-block btn-danger btn-xs removeProductToCrat" prdId="{prdId}" action="remove">-</button>
                                        </div>
                                        <div class="col-sm-3">
                                            <center>
                                                <span prdId="{prdId}">{amount}</span>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                            <button type="button" class="btn btn-block btn-success btn-xs addProductToCrat" prdId="{prdId}" action="add">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="template" id="noDataCard">
                            <h1 class="text-gray">
                                <center><?=$noData?></center>
                            </h1>
                        </div>

                        <div class="row">
                            <div class="col-md-12" id="productCategory">
                                <!-- Crad List -->
                            </div>
                            <div class="col-md-12">
                                <ul class="pagination paginationProductList pull-right">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div class="row">
                            <div class="col-md-12" id="myProductCategory">
                                <!-- Crad List -->
                            </div>
                            <div class="col-md-12">
                                <ul class="pagination paginationMyOrderList pull-right">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


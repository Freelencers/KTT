<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        <?=$pageTitle?> 
        </h1>
    </section>

    <!-- Main content -->
    <section class="content" id="invoidPDF">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h1>Kratatong</h1>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="box box-solid">
                                    <div class="box-body">
                                        <p>ปาท่องโก๋กระทะทอง</p>
                                        <p>249 ถ.สุขุมวิท ต.แสนสุข ตลาดหนองมน</p>
                                        <p>อ.เมือง</p>
                                        <p>จ.ชลบุรี</p>
                                        <p>20130</p>
                                        <p>089-936-8257</p>
                                        <p>patonggo.gtt@yahoo.com</p>
                                    </div>
                                    <!-- /.box-body -->
                                </div>                       
                            </div> 
                            <div class="col-md-4">
                                <div class="box box-solid">
                                    <div class="box-body">
                                        <p id="cusFullName"></p>
                                        <p id="addDetail"></p>
                                        <p id="prvName"></p>
                                        <p id="disName"></p>
                                        <p id="addPostcode"></p>
                                        <p id="phone"></p>
                                        <p id="email"></p>
                                    </div>
                                    <!-- /.box-body -->
                                </div>  
                            </div> 
                            <div class="col-md-4">
                                <div class="box box-solid">
                                    <div class="box-body">
                                        <p>
                                            <?=$code?> : 
                                            <span id="ordCode"></span>
                                        </p>                                    
                                        <p>
                                            <?=$customerCode?>: 
                                            <span id="cusCode"></span>
                                        </p>
                                        <p>
                                            <?=$date?>: 
                                            <span id="ordCreatedate"></span>
                                        </p>                                       
                                        <p>
                                            <?=$accountName?>: 
                                            <span id="">สมเกียรติ ทวีพาณิชย์กุล</span>
                                        </p>                                       
                                        <p>
                                            <?=$accountNo?>: 
                                            <span id="">454-2-22110-8</span>
                                        </p>                                       
                                        <p>
                                            <?=$bank?>: 
                                            <span id="">TMB</span>
                                        </p>                                       
                                        <p>
                                            <?=$type?>: 
                                            <span id="">ออมทรัพย์</span>
                                        </p>                                       
                                    </div>
                                    <!-- /.box-body -->
                                </div>  
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <!-- template -->
                                <table class="template" id="invoidTemplate">
                                    <tbody>
                                        <tr>
                                            <td>{sodQty}</td>
                                            <td>{untName}</td>
                                            <td>{matName}</td>
                                            <td>{point}</td>
                                            <td>{price}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table class="table table-bordered table-hover pb-0">
                                    <thead>
                                        <th><?=$qty?></th>
                                        <th><?=$unit?></th>
                                        <th><?=$product?></th>
                                        <th><?=$point?></th>
                                        <th><?=$price?></th>
                                    </thead>
                                    <tbody id="tbodyInvoid">
                                    <!-- item list --> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="button" class="btn bg-primary" id="buttonGeneratePDF">
                                    <i class="fa fa-fw fa-print"></i><?=$print?>
                                </button>
                                <button type="button" class="btn bg-primary" id="complete">
                                    <i class="fa fa-fw fa-save"></i><?=$complete?>
                                </button>
                            </div>
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td><?=$subTotal?></td>
                                            <td>
                                                <span id="subTotal">0</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=$shipping?></td>
                                            <td>
                                                <input class="form-control" id="shipping" value=0>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=$tax?></td>
                                            <td>
                                                <span id="tax">0</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><?=$grandTotal?></td>
                                            <td>
                                                <span id="grandTotal">0</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


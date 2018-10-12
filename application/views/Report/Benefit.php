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
                        <h3 class="box-title"><?=$filterTitle?></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <select class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"><?=$costByProduct?> 
                                    </label>
                               </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"><?=$costByExpense?> 
                                    </label>
                               </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"><?=$includeWaiting?> 
                                    </label>
                               </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                            <button type="button" class="btn btn-block btn-primary" id="processButton" ><?=$process?></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn bg-maroon btn-flat margin col-md-12"><?=$income?></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn bg-maroon btn-flat margin col-md-12"><?=$expense?></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn bg-maroon btn-flat margin col-md-12"><?=$profit?></button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><?=$filterTitle?></h3>
                </div>
                <div class="box-body">

                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        <?=$pageTitle?> 
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$defaultSetting?></h3>
        </div>
        <div class="box-body defaultSettingForm">
            <div class="row">
                <div class="col-md-6">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group">
                            <label><?=$moneyToPoint?></label>
                            <input type="text" class="form-control autoGet validateDefaultSettingForm" require="true" id="moneyToPoint">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label><?=$tax?></label>
                            <input type="text" class="form-control autoGet validateDefaultSettingForm" require="true" id="tax">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label><?=$standardPoint?></label>
                            <input type="text" class="form-control autoGet validateDefaultSettingForm" require="true" id="standardPoint">
                            <span class="help-block"></span>
                        </div>
                    </form>
                </div>
                <div class="col-md-6">
                    <form role="form">
                        <!-- text input -->
                        <div class="form-group">
                            <label><?=$pointToMoneyLevelS?></label>
                            <input type="text" class="form-control autoGet validateDefaultSettingForm" require="true" id="pointToMoneyLevelS">
                            <span class="help-block"></span>
                        </div>
                        <div class="form-group">
                            <label><?=$pointToMoneyLevelL?></label>
                            <input type="text" class="form-control autoGet validateDefaultSettingForm" require="true" id="pointToMoneyLevelL">
                            <span class="help-block"></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <?=$memberFee?>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="box-body">
                                <form role="form">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label>Level S</label>
                                        <input type="text" class="form-control autoGet validateDefaultSettingForm" require="true" id="sFee">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label>Level L</label>
                                        <input type="text" class="form-control autoGet validateDefaultSettingForm" require="true" id="lFee">
                                        <span class="help-block"></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                <?=$specialCondition?>
                            </h4>
                        </div>
                        <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="box-body">
                                <form role="form">
                                    <!-- text input -->
                                    <div class="form-group">
                                        <label><?=$pounderWeight?></label>
                                        <input type="text" class="form-control autoGet validateDefaultSettingForm" require="true" id="pounderWeight">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label><?=$commission?></label>
                                        <input type="text" class="form-control autoGet validateDefaultSettingForm" require="true" id="commission">
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="form-group">
                                        <label><?=$refer?></label>
                                        <input type="text" class="form-control autoGet validateDefaultSettingForm" require="true" id="refer">
                                        <span class="help-block"></span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <button class="btn btn-success pull-right" id="saveSettingDefault">Save</button>
        </div>
        <!-- /.box-footer-->
        </div>
        <!-- /.box -->

        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab"><?=$schedule?></a></li>
                        <li><a href="#tab_2" data-toggle="tab"><?=$history?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <!-- Template setting shcedule -->
                            <table class="template" id="rowTemplateSchedule">
                                <tbody>
                                    <tr>
                                        <td>{dateStart}</td>
                                        <td>{dateEnd}</td>
                                        <td>{moneyToPoint}</td>
                                        <td>{pointToMoneyLevel-S}</td>
                                        <td>{pointToMoneyLevel-L}</td>
                                        <td>{tax}</td>
                                        <td>{S-Fee}</td>
                                        <td>{L-Fee}</td>
                                        <td>{pounderWeight}</td>
                                        <td>{commission}</td>
                                        <td>{refer}</td>
                                        <td>{standardPoint}</td>
                                        <td>
                                            <i class="fa fa-fw fa-edit pointer changeSettingDetail {disabled}" ssgId="{ssgId}"></i>
                                            <i class="fa fa-fw fa-trash pointer {disabled}" onclick="deleteConfirmBox({ssgId})"></i>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary pull-right" id="createScheduleButton"><?=$createSchedule?></button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <th><?=$dateStart?></th>
                                            <th><?=$dateEnd?></th>
                                            <th><?=$moneyToPoint?></th>
                                            <th><?=$pointToMoneyLevelL?></th>
                                            <th><?=$pointToMoneyLevelS?></th>
                                            <th><?=$tax?></th>
                                            <th>S</th>
                                            <th>L</th>
                                            <th><?=$pounderWeight?></th>
                                            <th><?=$commission?></th>
                                            <th><?=$refer?></th>
                                            <th><?=$standardPoint?></th>
                                            <th><?=$action?></th>
                                        </thead>
                                        <tbody id="tbodyScheduleList">
                                        </tbody>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="pagination paginationList pull-right">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                        <!-- Template Schedule History -->
                        <table class="template" id="rowTemplateHistory">
                                <tbody>
                                    <tr>
                                        <td>{date}</td>
                                        <td>{moneyToPoint}</td>
                                        <td>{pointToMoneyLevel-S}</td>
                                        <td>{pointToMoneyLevel-L}</td>
                                        <td>{tax}</td>
                                        <td>{S-Fee}</td>
                                        <td>{L-Fee}</td>
                                        <td>{pounderWeight}</td>
                                        <td>{commission}</td>
                                        <td>{refer}</td>
                                        <td>{standardPoint}</td>
                                    </tr>
                                </tbody>
                            </table>
                        <table class="table table-bordered table-hover">
                            <thead>
                                <th><?=$date?></th>
                                <th><?=$moneyToPoint?></th>
                                <th><?=$pointToMoneyLevelL?></th>
                                <th><?=$pointToMoneyLevelS?></th>
                                <th><?=$tax?></th>
                                <th>S</th>
                                <th>L</th>
                                <th><?=$pounderWeight?></th>
                                <th><?=$commission?></th>
                                <th><?=$refer?></th>
                                <th><?=$standardPoint?></th>
                            </thead>
                            <tbody id="tbodyHistoryList">
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="pagination paginationList pull-right">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- Craete shcedule modal -->
<div class="modal fade modal-default" id="modal-createSchedule" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$this->lang->line("systemSettingModalTitle")?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form role="form">
                            <!-- text input -->
                            <div class="form-group">
                                <label><?=$dateStart." - ".$dateEnd?></label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right dateRang autoGet validateScheduleSettingForm" require="true" id="scheduleDateRang">
                                </div>
                                <span class="help-block"></span>
                                <!-- /.input group -->
                            </div>
                            <div class="form-group">
                                <label><?=$moneyToPoint?></label>
                                <input type="text" class="form-control autoGet validateScheduleSettingForm" require="true" id="moneyToPoint">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label><?=$tax?></label>
                                <input type="text" class="form-control autoGet validateScheduleSettingForm" require="true" id="tax">
                                <span class="help-block"></span>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form role="form">
                            <!-- text input -->
                            <div class="form-group">
                                <label><?=$pointToMoneyLevelS?></label>
                                <input type="text" class="form-control autoGet validateScheduleSettingForm" require="true" id="pointToMoneyLevelS">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label><?=$pointToMoneyLevelL?></label>
                                <input type="text" class="form-control autoGet validateScheduleSettingForm" require="true" id="pointToMoneyLevelL">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label><?=$standardPoint?></label>
                                <input type="text" class="form-control autoGet validateScheduleSettingForm" require="true" id="standardPoint">
                                <span class="help-block"></span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <?=$memberFee?>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="box-body">
                                    <form role="form">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Level S</label>
                                            <input type="text" class="form-control autoGet validateScheduleSettingForm" require="true" id="sFee">
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Level L</label>
                                            <input type="text" class="form-control autoGet validateScheduleSettingForm" require="true" id="lFee">
                                            <span class="help-block"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <?=$specialCondition?>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="box-body">
                                    <form role="form">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label><?=$pounderWeight?></label>
                                            <input type="text" class="form-control autoGet validateScheduleSettingForm modalInput" require="true" id="pounderWeight">
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label><?=$commission?></label>
                                            <input type="text" class="form-control autoGet validateScheduleSettingForm modalInput" require="true" id="commission">
                                            <span class="help-block"></span>
                                        </div>
                                        <div class="form-group">
                                            <label><?=$refer?></label>
                                            <input type="text" class="form-control autoGet validateScheduleSettingForm modalInput" require="true" id="refer">
                                            <span class="help-block"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$this->lang->line("generalClose")?></button>
                <button type="button" class="btn btn-success" id="saveButtonModal"><?=$this->lang->line("generalSave")?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

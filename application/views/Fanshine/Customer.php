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
                                <button type="button" class="btn btn-block btn-primary" id="createNewAcountButtom"><?=$createNewFanshine?></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <!-- template -->
                        <table class="template" id="rowTemplate">
                            <tbody>
                                <tr>
                                    <td>{cusCode}</td>
                                    <td>{cusFullName}</td>
                                    <td>{cusCreatedate}</td>
                                    <td>{cusStatus}</td>
                                    <td>{cusLevel}</td>
                                    <td>
                                        <i class="fa fa-fw fa-arrow-circle-up levelUp pointer" cusId="{cusId}" cusLevel="{cusLevel}"></i>
                                        <i class="fa fa-fw fa-edit changeCustomerDetail pointer" data-cusId="{cusId}"></i>
                                        <i class="fa fa-fw fa-trash pointer" onclick="deleteConfirmBox({cusId})"></i>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$code?></th>
                                <th><?=$fullName?></th>
                                <th><?=$createdate?></th>
                                <th><?=$status?></th>
                                <th><?=$level?></th>
                                <th><?=$action?></th>
                            </thead>
                            <tbody id="tbodyDataList">
                                
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

<div class="modal fade" id="modal-levelUp" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-solid bg-maroon pointer levelUpButton" id="buttonLevelS" level="S">

                            <!-- /.box-header -->
                            <div class="box-body">
                                <center>
                                    <h1 style="font-size: 300px">S</h1>
                                </center>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="box box-solid bg-purple pointer levelUpButton" id="buttonLevelL" level="L">

                            <!-- /.box-header -->
                            <div class="box-body">
                                <center>
                                    <h1 style="font-size: 300px">L</h1>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?=$close?></button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modal-createNewAccount" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form role="form">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?=$fanshineName?></label>
                                <input type="text" class="form-control autoGet validate cusList" require="true" id="cusFanshineName">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label><?=$fullName?></label>
                                <input type="text" class="form-control autoGet validate cusList" require="true" id="cusFullName">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-9">
                                        <label><?=$birthday?></label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control datepicker cusList validate" require="true" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" id="cusDateOfBirth">
                                        </div>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label><?=$level?></label>
                                        <select class="form-control autoGet validate cusList" require="true" id="cusLevel">
                                            <option value="S">S</option>
                                            <option value="L">L</option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$country?></label>
                                <select class="form-control autoGet validate cusList" require="true" id="cusCouId">
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label><?=$passportId?></label>
                                <input type="text" class="form-control autoGet cusList" id="cusPassportId">
                            </div>
                            <div class="form-group">
                                <label><?=$personalId?></label>
                                <input type="text" class="form-control autoGet validate cusList" require="true" id="cusPersonalId">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label><?=$address?></label>
                                <input type="text" class="form-control autoGet validate addList addProfile" require="true" id="addDetail">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$province?></label>
                                        <select class="form-control autoGet validate addList addProfile province" require="true" id="addProvince">
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$district?></label>
                                        <select class="form-control autoGet validate addList addProfile districtProfile" require="true" id="addDistrict">
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?=$postcode?></label>
                                <input type="text" class="form-control autoGet validate addList addProfile" require="true" id="addPostcode">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label><?=$phoneNumber?></label>
                                <input type="text" class="form-control autoGet validate contactList" require="true" id="conPhone">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label><?=$email?></label>
                                <input type="text" class="form-control autoGet validate contactList" require="true" id="conEmail">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label><?=$deliveryAddress?></label>
                                <input type="text" class="form-control autoGet validate addList addDelivery" require="true" id="addDetail">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$province?></label>
                                        <select class="form-control autoGet validate addList addDelivery province" require="true" id="addProvince">
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$district?></label>
                                        <select class="form-control autoGet validate addList addDelivery districtDelivery" require="true" id="addDistrict">
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$postcode?></label>
                                <input type="text" class="form-control autoGet validate addList addDelivery" require="true" id="addPostcode">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$bank?></label>
                                        <select class="form-control autoGet validate bankAccountDetail" require="true" id="bacBanId">
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$bankAccount?></label>
                                        <input type="text" class="form-control autoGet validate bankAccountDetail" require="true" id="bacNumber">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$branch?></label>
                                <input type="text" class="form-control autoGet validate bankAccountDetail" require="true" id="bacBranch">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label><?=$accountType?></label>
                                        <select class="form-control autoGet validate bankAccountDetail" require="true" id="bacType">
                                            <option value="SAVING"><?=$savingAccount?></option>
                                            <option value="CURRENT"><?=$currentAccount?></option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$accountName?></label>
                                <input type="text" class="form-control autoGet validate bankAccountDetail" require="true" id="bacName">
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <label><?=$refer?></label>
                                <select class="form-control autoGet validate cusList" require="true" id="cusReferId">
                                </select>
                                <span class="help-block"></span>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$maritalStatus?></label>
                                        <select class="form-control autoGet validate cusList" require="true" id="cusMarital">
                                            <option value="MARRIED"><?=$this->lang->line("fanshineCustomerSingle")?></option>
                                            <option value="SINGLE"><?=$this->lang->line("fanshineCustomerMarried")?></option>
                                        </select>
                                        <span class="help-block"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$child?></label>
                                        <input type="text" class="form-control autoGet validate cusList" require="true" id="cusChild">
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$descendantName?></label>
                                <input type="text" class="form-control autoGet validate cusList" require="true" id="cusDescedant">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </form>
                </div>
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
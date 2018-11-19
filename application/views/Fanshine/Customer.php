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
                                <input type="text" class="form-control autoGet cusList" id="cusFanshineName">
                            </div>
                            <div class="form-group">
                                <label><?=$fullName?></label>
                                <input type="text" class="form-control autoGet cusList" id="cusFullName">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-9">
                                        <label><?=$birthday?></label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control datemask cusList" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="" id="cusDateOfBirth">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label><?=$level?></label>
                                        <select class="form-control autoGet cusList" id="cusLevel">
                                            <option value="S">S</option>
                                            <option value="L">L</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$country?></label>
                                <select class="form-control autoGet cusList" id="cusCouId">
                                </select>
                            </div>
                            <div class="form-group">
                                <label><?=$passportId?></label>
                                <input type="text" class="form-control autoGet cusList" id="cusPassportId">
                            </div>
                            <div class="form-group">
                                <label><?=$personalId?></label>
                                <input type="text" class="form-control autoGet cusList" id="cusPersonalId">
                            </div>
                            <div class="form-group">
                                <label><?=$address?></label>
                                <input type="text" class="form-control autoGet addList addProfile" id="addDetail">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$province?></label>
                                        <select class="form-control autoGet addList addProfile province" id="addProvince">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$district?></label>
                                        <select class="form-control autoGet addList addProfile districtProfile" id="addDistrict">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?=$postcode?></label>
                                <input type="text" class="form-control autoGet addList addProfile" id="addPostcode">
                            </div>
                            <div class="form-group">
                                <label><?=$phoneNumber?></label>
                                <input type="text" class="form-control autoGet contactList" id="conPhone">
                            </div>
                            <div class="form-group">
                                <label><?=$email?></label>
                                <input type="text" class="form-control autoGet contactList" id="conEmail">
                            </div>
                            <div class="form-group">
                                <label><?=$deliveryAddress?></label>
                                <input type="text" class="form-control autoGet addList addDelivery" id="addDetail">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$province?></label>
                                        <select class="form-control autoGet addList addDelivery province" id="addProvince">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$district?></label>
                                        <select class="form-control autoGet addList addDelivery districtDelivery" id="addDistrict">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$postcode?></label>
                                <input type="text" class="form-control autoGet addList addDelivery" id="addPostcode">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$bank?></label>
                                        <select class="form-control autoGet bankAccountDetail" id="bacBanId">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$bankAccount?></label>
                                        <input type="text" class="form-control autoGet bankAccountDetail" id="bacNumber">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$branch?></label>
                                <input type="text" class="form-control autoGet bankAccountDetail" id="bacBranch">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label><?=$accountType?></label>
                                        <select class="form-control autoGet bankAccountDetail" id="bacType">
                                            <option value="SAVING"><?=$savingAccount?></option>
                                            <option value="CURRENT"><?=$currentAccount?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$accountName?></label>
                                <input type="text" class="form-control autoGet bankAccountDetail" id="bacName">
                            </div>
                            <div class="form-group">
                                <label><?=$refer?></label>
                                <select class="form-control autoGet cusList" id="cusReferId">
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$maritalStatus?></label>
                                        <select class="form-control autoGet cusList" id="cusMarital">
                                            <option value="MARRIED"><?=$this->lang->line("fanshineCustomerSingle")?></option>
                                            <option value="SINGLE"><?=$this->lang->line("fanshineCustomerMarried")?></option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$child?></label>
                                        <input type="text" class="form-control autoGet cusList" id="cusChild">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$descendantName?></label>
                                <input type="text" class="form-control autoGet cusList" id="cusDescedant">
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
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
                                        <i class="fa fa-fw fa-edit" data-cusId="{cusId}"></i>
                                        <i class="fa fa-fw fa-trash" onclick="deleteConfirmBox({cusId})"></i>
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
                                            <input type="text" class="form-control datemask" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label><?=$level?></label>
                                        <select class="form-control autoGet cusList" id="cusLevel">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$country?></label>
                                <select class="form-control autoGet cusList" id="cusCountry">
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
                                        <select class="form-control autoGet addList addProfile" id="addProvince">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$district?></label>
                                        <select class="form-control autoGet addList addProfile" id="addDistrict">
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
                                        <select class="form-control autoGet addList addDelivery" id="addProvince">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$district?></label>
                                        <select class="form-control autoGet addList addDelivery" id="addDistrict">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$bank?></label>
                                        <select class="form-control autoGet bankList" id="bacBanId">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$bankAccount?></label>
                                        <input type="text" class="form-control autoGet bankList" id="bacNumber">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$branch?></label>
                                <input type="text" class="form-control autoGet bankList" id="bacBranch">
                            </div>
                            <div class="form-group">
                                <label><?=$accountName?></label>
                                <input type="text" class="form-control autoGet bankList" id="bacName">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?=$refer?></label>
                                <select class="form-control autoGet" id="cusRefer">
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$maritalStatus?></label>
                                        <select class="form-control autoGet" id="cusMaritalStatus">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$child?></label>
                                        <input type="text" class="form-control autoGet" id="cusChild">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$descendantName?></label>
                                <input type="text" class="form-control autoGet" id="cusDescendantName">
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
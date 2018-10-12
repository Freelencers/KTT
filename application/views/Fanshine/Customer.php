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
                                <button type="button" class="btn btn-block btn-primary" id="createNewAcountButtom" data-toggle="modal" data-target="#modal-createNewAccount"><?=$createNewFanshine?></button>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                                <th><?=$code?></th>
                                <th><?=$fullName?></th>
                                <th><?=$createdate?></th>
                                <th><?=$status?></th>
                                <th><?=$level?></th>
                                <th><?=$action?></th>
                            </thead>
                            <tbody>
                                <tr id="accountColumnTemplate">
                                    <td>{code}</td>
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
                                <input type="text" class="form-control" id="cusFanshineName">
                            </div>
                            <div class="form-group">
                                <label><?=$fullName?></label>
                                <input type="text" class="form-control" id="cusFullName">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><?=$day?></label>
                                        <select class="form-control" id="cusDayBirth">
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label><?=$month?></label>
                                        <select class="form-control" id="cusMonthBirth">
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label><?=$year?></label>
                                        <select class="form-control" id="cusYearBirth">
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label><?=$level?></label>
                                        <select class="form-control" id="cusLevel">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$country?></label>
                                <input type="text" class="form-control" id="cusCountry">
                            </div>
                            <div class="form-group">
                                <label><?=$passportId?></label>
                                <input type="text" class="form-control" id="cusPassportId">
                            </div>
                            <div class="form-group">
                                <label><?=$personalId?></label>
                                <input type="text" class="form-control" id="cusPersonalId">
                            </div>
                            <div class="form-group">
                                <label><?=$address?></label>
                                <input type="text" class="form-control" id="cusAddress">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$province?></label>
                                        <select class="form-control" id="cusProvince">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$district?></label>
                                        <select class="form-control" id="cusDistrict">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?=$postcode?></label>
                                <input type="text" class="form-control" id="cusPostcode">
                            </div>
                            <div class="form-group">
                                <label><?=$phoneNumber?></label>
                                <input type="text" class="form-control" id="cusPhoneNumber">
                            </div>
                            <div class="form-group">
                                <label><?=$email?></label>
                                <input type="text" class="form-control" id="cusEmail">
                            </div>
                            <div class="form-group">
                                <label><?=$deliveryAddress?></label>
                                <input type="text" class="form-control" id="cusDeliveryAddress">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$province?></label>
                                        <select class="form-control" id="cusDeliveryProvince">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$district?></label>
                                        <select class="form-control" id="cusDeliveryDistrict">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$bank?></label>
                                        <select class="form-control" id="cusBank">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$bankAccount?></label>
                                        <input type="text" class="form-control" id="cusBankAccount">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$branch?></label>
                                <input type="text" class="form-control" id="cusBranch">
                            </div>
                            <div class="form-group">
                                <label><?=$accountName?></label>
                                <input type="text" class="form-control" id="cusAccountName">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><?=$refer?></label>
                                <select class="form-control" id="cusRefer">
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label><?=$maritalStatus?></label>
                                        <select class="form-control" id="cusMaritalStatus">
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label><?=$child?></label>
                                        <input type="text" class="form-control" id="cusChild">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><?=$descendantName?></label>
                                <input type="text" class="form-control" id="cusDescendantName">
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
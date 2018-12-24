// On load
var currentPage = 1;
var limitPage = 10;

loadTable(currentPage, limitPage, "");
loadProvince();
loadCountry();
loadBank();
loadRefer("","");

// on action

$(document).on("click", ".paginate_button", function(){

    currentPage = $(this).data("page");
    loadTable(currentPage, limitPage, "");
});

$("#createNewAcountButtom").click(function(){

    localStorage.setItem("modalStatus", "CREATE");
    clearForm();
    $("#modal-createNewAccount").modal();
});

$("#modalSaveButton").click(function(){

    if(validate(".validate")){

        actionCustomer();
    }
});

$(".province").change(function(){

    var addType = $(this).attr("class").indexOf("addProfile");
    var value = $(this).val();
    if(addType != -1){

        loadDistrict(value, ".districtProfile");
    }else{

        loadDistrict(value, ".districtDelivery");
    }
});

$(document).on("click", ".changeCustomerDetail", function(){

    localStorage.setItem("modalStatus", "UPDATE");
    var cusId = $(this).attr("data-cusId");
    var tempValue = "";
    clearDataForm(".modal-body");
    $.post(base_url + "/Fanshine/Customer/getCustomerDetailById", {"cusId" : cusId}, function(resp){

        resp = resp.response.dataRow;
        var tempElem = "";
        var tempId = "";
        // Get customer detail

        loadRefer("", cusId);
        $(".cusList").each(function(){

            if($(this).attr("id") == "cusDateOfBirth"){

                tempValue = convertDateToHuman(resp[$(this).attr('id')]);
            }else{

                tempValue = resp[$(this).attr('id')];
            }

            $(this).attr("cusId", resp.cusId);
            $(this).val(tempValue);
        });

        // Profile address
        $(".addProfile").each(function(){

            tempElem = $(this); 
            resp.cusAddList.forEach(function(row, index){

                if(row.addType == "PROFILE"){

                    tempId = tempElem.attr("id");
                    if(tempId == "addDistrict"){

                        loadDistrict(row.addProvince, ".districtProfile", row.addDistrict);
                    }else{

                        tempElem.val(row[tempId]);
                    }
                    tempElem.attr("addId", row.addId);
                }
            });
        });         


        // Delivery address
        $(".addDelivery").each(function(){

            tempElem = $(this); 
            resp.cusAddList.forEach(function(row, index){

                if(row.addType == "DELIVERY"){

                    tempId = tempElem.attr("id");
                    if(tempId == "addDistrict"){

                        loadDistrict(row.addProvince, ".districtDelivery", row.addDistrict);
                    }else{

                        tempElem.val(row[tempId]);
                    }
                    tempElem.attr("addId", row.addId);
                }
            });
        });   

        // Contact
        resp.cusContactList.forEach(function(row, index){
            
            if(row.conName == "PHONE"){

                $("#conPhone").val(row.conValue);
                $('#conPhone').attr("conId", row.conId);
            }else{

                $("#conEmail").val(row.conValue);
                $('#conEmail').attr("conId", row.conId);
            }
        });

        // Bank
        $(".bankAccountDetail").each(function(){
           
            tempId = $(this).attr("id");

            if(tempId == "bacBanId"){

                loadBank(resp.bankAccountDetail[0].bacBanId);
            }else{

                $(this).val(resp.bankAccountDetail[0][tempId]);
            }
            $(this).attr("bacId", resp.bankAccountDetail[0].bacId);
        });

        $("#modal-createNewAccount").modal();
    },"json");
});

$("#deleteButtonConfirm").click(function(){

    var cusId = $(this).data("id");
    $.post(base_url + "/Fanshine/Customer/deleteCustomer", {"cusId" : cusId}, function(resp){

        $("#modal-deleteConfirm").modal("hide");
        loadTable(currentPage, limitPage, "");
    });
});

$(document).on("click", ".levelUp", function(){

    var cusId = $(this).attr("cusId");
    var cusLevel = $(this).attr("cusLevel");

    // set localStorage
    localStorage.setItem("cusId", cusId);

    if(cusLevel == "S"){

        // Disable S
        $("#buttonLevelS").removeClass("bg-maroon");
        $("#buttonLevelS").removeClass("levelUpButton");
        $("#buttonLevelS").removeClass("pointer");
        $("#buttonLevelS").addClass("bg-gray");

        // Avialable L
        $("#buttonLevelL").addClass("levelUpButton");
        $("#buttonLevelL").addClass("bg-purple");
        $("#buttonLevelL").addClass("pointer");
    }else{

        // Disable L
        $("#buttonLevelL").removeClass("levelUpButton");
        $("#buttonLevelL").removeClass("bg-purple");
        $("#buttonLevelL").removeClass("pointer");
        $("#buttonLevelL").addClass("bg-gray");

        // Avialable S
        $("#buttonLevelS").addClass("levelUpButton");
        $("#buttonLevelS").addClass("bg-maroon");
        $("#buttonLevelS").addClass("pointer");
    }
    $("#modal-levelUp").modal();
});

$(document).on("click", ".levelUpButton", function(){

    var cusId = localStorage.getItem("cusId");
    var cusLevel = $(this).attr("level"); 

    $.post(base_url + "/Fanshine/Customer/upgradeCustomerLevel", {"cusId" : cusId, "cusLevel" : cusLevel}, function(resp){
        
        loadTable(currentPage, limitPage, "");
        $("#modal-levelUp").modal("hide");
        $("#modal-success").modal();
    });
});
// defination

function loadTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/Fanshine/Customer/getCustomerList", json, function(resp){

        var columnTemplate = $("#rowTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", "7");
        }
        resp.response.dataList.forEach(function(row){
            replace = {
                "{cusCode}"                  : row.cusCode,
                "{cusId}"                    : row.cusId,
                "{cusFanshineName}"          : row.cusFanshineName,
                "{cusFullName}"              : row.cusFullName,
                "{cusLevel}"                 : row.cusLevel,
                "{cusCreatedate}"            : convertDateToHuman(row.cusCreatedate),
                "{cusStatus}"                : customerStatusLabel(row.cusStatus),
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyDataList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);
        loadRefer();
    },"json");
}

function loadProvince(){
    $.post(base_url + "/Fanshine/Customer/getProvince", {}, function(resp){

        var options = "";
        var optionElement = $("#option").html();

        resp.response.dataList.forEach(function(row){

            replace = {
                "{title}" : row.prvName,
                "{value}" : row.prvId,
                "{selected}" : ""
            }
            option += replaceAll(optionElement, replace);
        });
        $(".province").html(option);

        // set Default District
        loadDistrict(1, ".districtProfile");
        loadDistrict(1, ".districtDelivery");

    }, "json");
}

function loadDistrict(disPrvId, disRef, selectedId=""){

    $.post(base_url + "/Fanshine/Customer/getDistrict", {"disPrvId" : disPrvId}, function(resp){
        var options = "";
        var optionElement = $("#option").html();
        var selected = "";

        resp.response.dataList.forEach(function(row){


            if(row.disId == selectedId){

                selected = "selected";
            }else{

                selected = "";
            }

            replace = {
                "{title}" : row.disName,
                "{value}" : row.disId,
                "{selected}" : selected 
            }
            options += replaceAll(optionElement, replace);
        });
        $(disRef).html(options);
    }, "json");
}

function loadCountry(){

    $.post(base_url + "/Fanshine/Customer/getCountry", {}, function(resp){
        var options = "";
        var optionElement = $("#option").html();

        resp.response.dataList.forEach(function(row){

            replace = {
                "{title}" : row.ctrName,
                "{value}" : row.ctrId,
                "{selected}" : ""
            }
            options += replaceAll(optionElement, replace);
        });
        $("#cusCouId").html(options);
    }, "json");
}

function loadBank(selectedId){

    $.post(base_url + "/Fanshine/Customer/getBank", {}, function(resp){
        var options = "";
        var optionElement = $("#option").html();
        var selected = "";
       
        resp.response.dataList.forEach(function(row){

            if(row.bacId == selectedId){

                selected = "selected";
            }else{
                 
                selected = "";
            }

            replace = {
                "{title}" : row.banName,
                "{value}" : row.banId,
                "{selected}" : selected
            }
            options += replaceAll(optionElement, replace);
        });
        $("#bacBanId").html(options);
    }, "json");
}

function loadRefer(search, except=""){

    $.post(base_url + "/Fanshine/Customer/getRefer", {"search": "", "except" : except}, function(resp){
        var options = "";
        var optionElement = $("#option").html();
        var disabled = "";

        if(resp.response.dataList.length){
            resp.response.dataList.forEach(function(row){

                if(row.cusRefTime >= 2){

                    disabled = "disabled";
                }else{
                    
                    disabled = "";
                }
                replace = {
                    "{title}" : row.cusCode + " : " + row.cusFullName,
                    "{value}" : row.cusId,
                    "{selected}" : "",
                    "{disabled}" : disabled
                }
                options += replaceAll(optionElement, replace);
            });
        }else{
            
            replace = {
                "{title}" : "No Fanshine",
                "{value}" : 0,
                "{selected}" : "selected"
            }
            options += replaceAll(optionElement, replace);
        }
        $("#cusReferId").html(options);
    }, "json");
}

function actionCustomer(){

    var json = {};
    var modalStatus = localStorage.getItem("modalStatus");

    // Get customer detail
    $(".cusList").each(function(){

        if(modalStatus == "UPDATE"){

            json["cusId"] = $(this).attr("cusId");
        }

        if($(this).attr("id") == "cusDateOfBirth"){

            json[$(this).attr("id")] = convertDateToDatabase($(this).val());
        }else{

            json[$(this).attr("id")] = $(this).val();
        }
    });

    // Get address
    json["cusAddList"] = new Array();
    json["cusAddList"][0] = {};
    json["cusAddList"][1] = {};

    // Profile address
    $(".addProfile").each(function(){

        if(modalStatus == "UPDATE"){

            json["cusAddList"][0]["addId"] = $(this).attr("addId");
        }
        json["cusAddList"][0][$(this).attr("id")] = $(this).val();
        json["cusAddList"][0]["addType"] = "PROFILE"; 
    });         

    // Delivery address
    $(".addDelivery").each(function(){

        if(modalStatus == "UPDATE"){

            json["cusAddList"][1]["addId"] = $(this).attr("addId");
        }
        json["cusAddList"][1][$(this).attr("id")] = $(this).val();
        json["cusAddList"][1]["addType"] = "DELIVERY"; 
    });         
  
    // Bank
    json["bankAccountDetail"] = new Array();
    json["bankAccountDetail"][0] = {};
    $(".bankAccountDetail").each(function(){

        if(modalStatus == "UPDATE"){

            json["bankAccountDetail"][0]["bacId"] = $(this).attr("bacId");
        }
        json["bankAccountDetail"][0][$(this).attr("id")] = $(this).val();
    });  

    // Contact
    json["cusContactList"] = new Array();
    json["cusContactList"][0] = {};
    json["cusContactList"][1] = {};

    
    json["cusContactList"][0]["conName"] = "PHONE";
    json["cusContactList"][0]["conValue"] = $("#conPhone").val();

    
    json["cusContactList"][1]["conName"] = "EMAIL";
    json["cusContactList"][1]["conValue"] = $("#conEmail").val();

    if(modalStatus == "UPDATE"){

        json["cusContactList"][0]["conId"] = $("#conPhone").attr("conId");
        json["cusContactList"][1]["conId"] = $("#conEmail").attr("conId");
    }


    var apiTarget = "";
    if(modalStatus == "CREATE"){

        apiTarget = "/Fanshine/Customer/createNewCustomer";
    }else{

        apiTarget = "/Fanshine/Customer/updateCustomerDetail";
    }

    $.post(base_url + apiTarget, {"CustomerData" : json}, function(resp){

        loadTable(currentPage, limitPage, "");
        $("#modal-createNewAccount").modal("hide");
        $("#modal-success").modal();
    });
}

function clearForm(){
    // Get customer detail
    $(".cusList").each(function(){

        $(this).val("");
    });

    // Profile address
    $(".addProfile").each(function(){

        $(this).val("");
    });         


    // Delivery address
    $(".addDelivery").each(function(){

        $(this).val("");
    });   

    // Contact
    $("#conPhone").val("");
    $("#conEmail").val("");

    // Bank
    $(".bankAccountDetail").each(function(){

        $(this).val("");
    });

    loadProvince();
    loadCountry();
    loadBank();
    loadDistrict( 1, ".districtProfile");
    loadDistrict( 1, ".districtDelivery");
    $("#cusCouId").val(0);
    $("#cusMarital").val("MARRIED");
    $("#cusLevel").val("S");
}

function customerStatusLabel(status){

    if(language == "english"){

        if(status == "NEW"){

            return "<span class='badge bg-maroon'>New</span>";
        }else{

            return " <span class='badge bg-red'>Pro</span>"
        }
    }else{

        if(status == "NEW"){

            return "<span class='badge bg-maroon'>สมาชิกใหม่</span>";
        }else{

            return " <span class='badge bg-red'>มืออาชีพ</span>"
        }
    }
}
// On load
var currentPage = 1;
var limitPage = 10;

loadTable(currentPage, limitPage, "");


// on action

$("#modalSaveButton").click(function(){

    if(validate(".validate")){

        createNewAccount();
    }
});

$("#deleteButtonConfirm").click(function(){

    var accId = $(this).data("id");
    $.post(base_url + "/System/Account/deleteAccount", {"accId" : accId}, function(resp){

        $("#modal-deleteConfirm").modal("hide");
        loadTable(currentPage, limitPage, "");
    });
});

$(document).on("click", ".updateAccount", function(){

    var accId = $(this).attr("accId");

    // assign to local storage
    localStorage.setItem("accId", accId);
    localStorage.setItem("createStatus", "update");

    $.post(base_url + "/System/Account/getAccountById", {"accId": accId}, function(resp){

        pushDataForm("#createNewAccountForm", resp.response.dataRow);
        $("#modal-createNewAccount").modal("show");
    },"json");
});

$("#createNewAcountButtom").click(function(){

    // clear form
    console.log("clear");
    clearDataForm(".modal-body");
    localStorage.setItem("createStatus", "CREATE"); 
    $("#modal-createNewAccount").modal("show");
});

$(document).on("click", ".paginate_button", function(){

    currentPage = $(this).data("page");
    loadTable(currentPage, limitPage, "");
});

// Definition

function loadTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/System/Account/getAllAccount", json, function(resp){

        var columnTemplate = $("#rowTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", "6");
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{no}" : no + 1,
                "{accId}" : row.accId,
                "{accFirstname}" : row.accFirstname,
                "{accLastname}" : row.accLastname,
                "{accUsername}" : row.accUsername,
                "{accCreatedate}" : row.accCreatedate
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyAccountList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);

    },"json");
}

function createNewAccount(){

    // get value from
    var json = getDataForm("#createNewAccountForm");

    // Check status of add
    var status = localStorage.getItem("createStatus");
    if(status == "update"){

        json["accId"] = localStorage.getItem("accId");
        $.post(base_url + "/System/Account/updateAccount", json, function(){

            loadTable(currentPage, limitPage, "");
            $("#modal-createNewAccount").modal("hide");
            clearDataForm();
        });
    }else{
        $.post(base_url + "/System/Account/createNewAccount", json, function(resp){

            loadTable(currentPage, limitPage, "");
            $("#modal-createNewAccount").modal("hide");
            clearDataForm();
        },"json");
    }

   
}
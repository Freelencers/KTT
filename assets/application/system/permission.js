// On load
loadTable(1, 10, "");
// on action

$(document).on("click", ".permissionModal", function(){

    $("#modal-permissionSetting").modal();
});

// Definition

function loadTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/System/Account/getAllAccount", json, function(resp){

        var columnTemplate = $("#tbodyAccountList").html();
        var no = 1;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow").html();
            tbody = tbody.replace("{colspan}", "6");
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{no}" : no,
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

            $("#modal-createNewAccount").modal("hide");
            clearDataForm();
        });
    }else{
        $.post(base_url + "/System/Account/createNewAccount", json, function(resp){

            $("#modal-createNewAccount").modal("hide");
            clearDataForm();
        },"json");
    }
}
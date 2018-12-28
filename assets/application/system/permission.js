// On load
var currentPage = 1;
var limitPage = 10;

loadTable(currentPage, limitPage, "");

// on action
$(document).on("click", ".permissionModal", function(){

    var accId = $(this).attr("data-accId");
    localStorage.setItem("accId", accId);
    getModulePermission(accId);
});

$(document).on("click", ".paginate_button", function(){

    currentPage = $(this).data("page");
    loadTable(currentPage, limitPage, "");
});

$(document).on("click", ".permissionAssign", function(){

    var accId = localStorage.getItem("accId");

    //access
    if($(this).is(':checked')){

        access = 1;
    }else{

        access = 0;
    }
    
    // set data json
    var json = {
        "accId" : accId,
        "modId" : $(this).attr("data-modId"),
        "access" :access 
    };

    $.post(base_url + "/System/Permission/changePermission", json, function(resp){
    
    },"json");
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
                "{accCreatedate}" : convertDateToHuman(row.accCreatedate)
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

function getModulePermission(accId){

    var templateSectionLabel = $("#templateSectionLabel").html();
    var templateCheckbox     = $("#templateCheckbox").html();
    var rowComponent         = $("#rowComponent").html();

    var innerDiv             = "";
    var modalBody            = "";
    var replace              = "";
    var checked              = "";

    $.post(base_url + "/System/Permission/getModuleList", {"accId" : accId}, function(resp){

        var disabled = "";
        response = resp.response;
        response.permissionList.forEach(permissionList => {

            replace = {
                "{section}" : permissionList.permissionSection
            };
            modalBody += replaceAll(templateSectionLabel, replace);

            // Clear old value
            innerDiv = "";

            permissionList.moduleList.forEach(moduleList => {

                // checked 
                if(moduleList.modPermission){

                    checked = "checked";
                }else{

                    checked = "";
                }

                // User can not set permission of own Permission Module
                disabled = "";
                if(accId == sessionAccId){

                    if(moduleList.modId == 3){
                        // Permission Module
                        disabled = "disabled";
                    }
                }
                replace = {
                    "{modId}" : moduleList.modId,
                    "{checked}" : checked,
                    "{modName}" : moduleList.modName,
                    "{disabled}" : disabled
                };
                innerDiv += replaceAll(templateCheckbox, replace);
                //console.log(templateCheckbox);
            });
            replace = {
                "{innerDiv}" : innerDiv
            };
            modalBody += replaceAll(rowComponent, replace);
        });
        $("#modal-permissionSetting .modal-body #bodyModal").html(modalBody);
        $("#modal-permissionSetting").modal();
    },"json");
}
// On load
var currentPage = 1;
var limitPage = 10;

loadTable(currentPage, limitPage, "");

// on action

$(document).on("click", ".paginate_button", function(){

    currentPage = $(this).data("page");
    loadTable(currentPage, limitPage, "");
});

$("#deleteButtonConfirm").click(function(){

    var locId = $(this).data("id");
    $.post(base_url + "/Wherehouse/Location/deleteLocation", {"locId" : locId}, function(resp){

        $("#modal-deleteConfirm").modal("hide");
        loadTable(currentPage, limitPage, "");
    });
});

// Create button click
$("#modalSaveButton").click(function(){

    createNewLocation();
});

$("#createLocatinoButton").click(function(){

    localStorage.setItem("createStatus", "CREATE");
    clearDataForm("#locationForm");
    $("#modal-createNewLocation").modal();
});

$(document).on("click", ".changeLocationDetail", function(){

    var locId = $(this).attr("locId");

    // assign to local storage
    localStorage.setItem("locId", locId);
    localStorage.setItem("createStatus", "UPDATE");

    $.post(base_url + "/Wherehouse/Location/getLocationDetailById", {"locId": locId}, function(resp){

        pushDataForm("#locationForm", resp.response.dataRow);
        $("#modal-createNewLocation").modal("show");
    },"json");
});
// Definition

function loadTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/Wherehouse/Location/getLocationList", json, function(resp){

        var columnTemplate = $("#rowTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 4);
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{no}" : no + 1,
                "{locName}" : row.locName,
                "{locDescription}" : row.locDetail,
                "{locId}" : row.locId,
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

function createNewLocation(){

    // get value from
    var json = getDataForm("#locationForm");

    // Check status of add
    var status = localStorage.getItem("createStatus");
    if(status == "UPDATE"){

        json["locId"] = localStorage.getItem("locId");
        $.post(base_url + "/Wherehouse/Location/updateLocationDetail", json, function(){

            loadTable(currentPage, limitPage, "");
            $("#modal-createNewLocation").modal("hide");
            clearDataForm("#locationForm");
        });
    }else{

        $.post(base_url + "/Wherehouse/Location/createNewLocation", json, function(resp){

            loadTable(currentPage, limitPage, "");
            $("#modal-createNewLocation").modal("hide");
            clearDataForm("#locationForm");
        },"json");
    }

   
}
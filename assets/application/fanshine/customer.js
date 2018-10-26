// On load
var currentPage = 1;
var limitPage = 10;

loadTable(currentPage, limitPage, "");

// Date mark
$('.datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });

// on action

$(document).on("click", ".paginate_button", function(){

    currentPage = $(this).data("page");
    loadTable(currentPage, limitPage, "");
});

$("#createNewAcountButtom").click(function(){

    localStorage.setItem("modalStatus", "CREATE");
    $("#modal-createNewAccount").modal();
});

$("#modalSaveButton").click(function(){

    var json = {};

    // Get customer detail
    $(".cusList").each(function(){

        json[$(this).attr("id")] = $(this).val();
    });

    // Get address
    json["addList"] = new Array();
    json["addList"][0] = {};
    json["addList"][1] = {};

    // Profile address
    $(".addProfile").each(function(){

        json["addList"][0][$(this).attr("id")] = $(this).val();
    });         

    // Delivery address
    $(".addProfile").each(function(){

        json["addList"][1][$(this).attr("id")] = $(this).val();
    });         
  
    // Bank
    json["bankList"] = new Array();
    json["bankList"][0] = {};
    $(".bankList").each(function(){

        json["bankList"][0][$(this).attr("id")] = $(this).val();
    });  

    // Contact
    json["contactList"] = new Array();
    json["contactList"][0] = {};
    json["contactList"][1] = {};

    json["contactList"][0]["conName"] = "PHONE";
    json["contactList"][0]["conValue"] = $("#conPhone").val();

    json["contactList"][1]["conName"] = "EMAIL";
    json["contactList"][1]["conValue"] = $("#conEmail").val();

    console.log(json);
});

// defination

function loadTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/Fanshine/Customer/getCustomerList", json, function(resp){

        console.log(resp);
        var columnTemplate = $("#rowTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow").html();
            tbody = tbody.replace("{colspan}", 7);
        }
        resp.response.dataList.forEach(function(row){
            console.log(row);
            replace = {
                "{cusCode}"                  : row.cusCode,
                "{cusId}"                    : row.cusUd,
                "{cusFanshineName}"          : row.cusFanshineName,
                "{cusFullName}"              : row.cusFullName,
                "{cusLevel}"                 : row.cusLevel,
                "{cusCreatedate}"            : convertDateToHuman(row.cusCreatedate),
                "{cusStatus}"                : row.cusStatus,
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyDataList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);
    },"json");
}

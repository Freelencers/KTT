// On load
var currentPage = 1;
var currentPageMaterial = 1;
var limitPage = 10;

loadTable(currentPage, limitPage, "");
getAmountToday();

// on action

$(document).on("click", ".paginationList > .paginate_button", function(){

    currentPage = $(this).data("page");
    loadTable(currentPage, limitPage, "");
});

$(".search").change(function(){

    loadTable(currentPage, limitPage, "");
});

$(".createNewExpense").click(function(){

    clearDataForm("#expenseForm");
    var expenseType = $(this).attr("epnType");
    $("#epnType").val(expenseType);
    $("#modal-createNewExpense").modal();
});

$("#modalSaveButton").click(function(){

    if(validate(".validate")){
        
        var input = getDataForm("#expenseForm");
        input["epnSection"] = "MANUAL";
        $.post(base_url + "/Account/Expense/createExpense", input, function(resp){
            
            loadTable(currentPage, limitPage, "");
            getAmountToday();
            $("#modal-createNewExpense").modal("hide");
        });
    }
});

$("#deleteButtonConfirm").click(function(){

    var epnId = $(this).data("id");
    $.post(base_url + "/Account/Expense/deleteExpense", {"epnId" : epnId}, function(resp){

        $("#modal-deleteConfirm").modal("hide");
        loadTable(currentPage, limitPage, "");
    });
});

// Definition

function loadTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : $("#search").val(),
        "startDate" : convertDateToDatabase($("#startDate").val()),
        "endDate" : convertDateToDatabase($("#endDate").val()),
        "type" : $("#type").val()
    };
    $.post(base_url + "/Account/Expense/getExpenseList", json, function(resp){

        var columnTemplate = $("#expenseTemplate tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 6);
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{date}" : convertDateToHuman(row.epnCreatedate),
                "{title}" : row.epnTitle,
                "{detail}" : row.epnDetail,
                "{type}" : row.epnType,
                "{amount}" : row.epnAmount,
                "{epnId}" : row.epnId
            }
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);
    },"json");
}

function getAmountToday(){

    $.post(base_url + "/Account/Expense/getExpenseListAndAmount", {}, function(resp){

        $("#expenseAmount").text(resp.response.amount.expense);
        $("#incomeAmount").text(resp.response.amount.income);
    },"json");
}

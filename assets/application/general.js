
// ON LOAD SECTION
$('.datepicker').datepicker({});

// DEFINATION

function replaceAll(str,mapObj){
    var re = new RegExp(Object.keys(mapObj).join("|"),"gi");

    // search if have template class will remove
    str = str.replace("template", "");
    return str.replace(re, function(matched){

        return mapObj[matched];
    });
}

function getDataForm(elementId){

    var json = {};
    // get data from element gave autoGet class
    $(elementId).find(".autoGet").each(function(element){

        json[$(this).attr("id")] = $(this).val();
    });

    return json;
}

function clearDataForm(elementId){

    $(elementId).find(".autoGet").each(function(){

        $(this).val("");
    });
}

function deleteConfirmBox(id){
  
  // set data id to button
  $("#deleteButtonConfirm").data("id", id);

  // open modal
  $("#modal-deleteConfirm").modal();
}

function pushDataForm(elementId, value){

    $(elementId).find(".autoGet").each(function(element){

        $(this).val(value[$(this).attr("id")]);
    });
}

function genPagination(paginationList){

    var paginationButton = $("#paginationTemplate");
    paginationButton = paginationButton.removeClass("template");
    paginationButton = paginationButton.html();

    var paginationHtml = "";
    var replace = {};
    paginationList.forEach(element => {

        replace = {
            "{status}" : element.status,
            "{page}" : element.page
        };
        paginationHtml += replaceAll(paginationButton, replace);
    });

    return paginationHtml;
}

function convertDateToHuman(date){

    // From yyyy-mm-dd to dd/mm/yyyy
    date = date.split("-");
    return date[2] + "/" + date[1] + "/" + (parseInt(date[0]) + 543);
}

function convertDateToDatabase(date){

    // From dd/mm/yyyy to yyyy-mm-dd
    date = date.split("/");
    return date[2] + "-" + date[1] + "-" + date[0];
}

function modalMessage(message){

    $("#modalMessage").text(message);
    $("#modal-message").modal();
}


function getLangLine(str){

    $.post(base_url + "/General/getLangLine", {"str": str}, function(resp){

        return resp.response;
    },"json");
}
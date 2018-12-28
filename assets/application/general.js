
// ON LOAD SECTION

$('.datepicker').datepicker({language:'th-th',format:'dd/mm/yyyy'});
// Date mark
$('.datemask').inputmask('99/99/9999', { 'placeholder': 'dd/mm/yyyy' });

// switch langua
$("#switchLanguau").click(function(){
    console.log("LANG");
    $.get(base_url + "/Auth/Access/languaue/" + $(this).attr("lang"), function(){

        location.reload();
    });
});

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

        $(this).closest(".form-group").removeClass("has-success");
        $(this).closest(".form-group").removeClass("has-error");
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

    // From yyyy-mm-dd Ato dd/mm/yyyy
    if(date){

        date = date.split("-");
        return date[2] + "/" + date[1] + "/" + (parseInt(date[0]) + 543);
    }else{

        return "";
    }
}

function convertDateToDatabase(date){

    // From dd/mm/yyyy to yyyy-mm-dd
    if(date){

        date = date.split("/");
        return (parseInt(date[2]) - 0) + "-" + date[1] + "-" + date[0];
    }else{

        return "";
    }
}

function modalMessage(message){

    $("#modalMessage").text(message);
    $("#modal-message").modal();
}


function getLangLine(str){

    console.log("LANG");
    $.ajax({
        url: base_url + "/General/getLangLine", 
        global: false,
        type: 'POST',
        data: {"str" : str},
        async: false, //blocks window close
        success: function(resp) {
            console.log(resp.response);
            return resp.response;
        }
    });
}

function validate(className){

    var require = "";
    var value = "";
    var fails = 0;
    $(className).each(function(){

        require = $(this).attr("require");
        //validType = $(this).attr("validType");
        value = $(this).val();

        console.log(require);
        if(require === "true"){

            if(value === ""){
                
                console.log(getLangLine("validateRequire"));
                $(this).closest(".form-group").addClass("has-error");
                $(this).closest(".form-group").removeClass("has-success");
                $(this).closest(".form-group").find(".help-block").text("กรุณากรอกข้อมูล");
                fails += 1;
            }else{

                $(this).closest(".form-group").removeClass("has-error");
                $(this).closest(".form-group").addClass("has-success");
                $(this).closest(".form-group").find(".help-block").text(""); 
            }
        }
    });

    if(fails > 0){

        return false;
    }else{

        return true;
    }
}

function moneyNumberFormat(nStr) {

    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
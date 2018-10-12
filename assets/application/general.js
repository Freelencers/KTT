function replaceAll(str,mapObj){
    var re = new RegExp(Object.keys(mapObj).join("|"),"gi");

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

    $(elementId).find(".autoGet").each(function(element){

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
// On load
var currentPage = 1;
var limitPage = 10;
var local = "";
loadSettingDefault();
loadScheduleTable(currentPage, limitPage, "");
loadHistoryTable(currentPage, limitPage, "");

if(language == "thai"){
    local = {
        format: 'DD/M/Y',
        applyLabel: "ตกลง",
        cancelLabel: "ยกเลิก",
        fromLabel: "จาก",
        toLabel: "ถึง",
        customRangeLabel: "Custom",
        daysOfWeek: [
            "จ",
            "อ",
            "พ",
            "พฤ",
            "ศ",
            "ส",
            "อา"
        ],
        monthNames: [
            "มกราคม",
            "กุมภาพันธ์",
            "มีนาคม",
            "เมษายน",
            "พฤษภาคม",
            "มิถุนายน",
            "กรกฎาคม",
            "สิงหาคม",
            "กันยายน",
            "ตุลาคม",
            "พฤศจิกายน",
            "ธันวาคม"
        ],
        "firstDay": 1
    }
}else{

    local = {
        format: 'DD/M/Y'
    }
}

$('.dateRang').daterangepicker({

    opens: 'left',
    locale: local,
}, function(start, end, label) {
    
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    console.log(start);
});

// on action
$("#createScheduleButton").click(function(){

    localStorage.setItem("modalStatus", "CREATE");
    $(".modal-body .autoGet").val("");
    $("#modal-createSchedule").modal();
});

$("#saveSettingDefault").click(function(){

    if(validate(".validateDefaultSettingForm")){

        var sedList = new Array();
        $(".defaultSettingForm .autoGet").each(function(){

            sedList.push({
                "sedId": $(this).attr("sedId"),
                "sedValue": $(this).val(),
                "sedname": $(this).attr("id")
            });
        });
        $.post(base_url + "/System/Setting/updateSettingDefault", {"sedList" : sedList}, function(resp){

            loadScheduleTable(currentPage, limitPage, "");
            loadHistoryTable(currentPage, limitPage, "");
            $("#modal-success").modal();
        },"json");
    }
});

$("#saveButtonModal").click(function(){

    if(validate(".validateScheduleSettingForm")){
        var modalStatus = localStorage.getItem("modalStatus");
        var scheduleList = {};
        var scheduleList = {};
        scheduleList["sscList"] = new Array();

        $(".modal-body .autoGet").each(function(){

            var value = $(this).val();
            var id = $(this).attr("id");
            var sscId = $(this).attr("sscId");
            var temp = "";


            if(id == "scheduleDateRang"){
                
                // Convert format to yyyy-mm-dd and split 
                temp = value.split(" - ");
                scheduleList["ssgDateStart"] = convertDateToDatabase(temp[0]);
                scheduleList["ssgDateEnd"]   = convertDateToDatabase(temp[1]);
            }else{

                if(modalStatus == "CREATE"){

                    // CREATE
                    scheduleList["sscList"].push({
                        "sscName" : id,
                        "sscValue" : value 
                    });
                }else{

                    // UPDTE
                    scheduleList["sscList"].push({
                        "sscId" : sscId,
                        "sscName" : id,
                        "sscValue" : value 
                    });
                }
            }
        });


        if(modalStatus == "CREATE"){

            // CREATE
            $.post(base_url + "/System/Setting/createSettingSchedule", scheduleList, function(resp){

                $("#modal-createSchedule").modal("hide");
                loadScheduleTable(currentPage, limitPage, "");
                $("#modal-success").modal();
            },"json");
        }else{

            // UPDATE
            scheduleList["ssgId"]   = localStorage.getItem("ssgId");
            $.post(base_url + "/System/Setting/updateSettingSchedule", scheduleList, function(resp){

                $("#modal-createSchedule").modal("hide");
                loadScheduleTable(currentPage, limitPage, "");
                $("#modal-success").modal();
            },"json");
        }
    }
});

$(document).on("click", ".changeSettingDetail", function(){

    var ssgId = $(this).attr("ssgId");
    localStorage.setItem("ssgId", ssgId);
    localStorage.setItem("modalStatus", "UPDATE");

    // check this schedule is working
    if($(this).attr("class").search("disabled") != -1){

        $.post(base_url + "/General/getLangLine", {"str": "generalScheduleLock"}, function(resp){

            modalMessage(resp.response);
        },"json");

        // Stop this function
        return true;
    }

    $.post(base_url + "/System/Setting/getSettingScheduleById", {"ssgId": ssgId}, function(resp){

        resp.response.settingScheduleGroup.settingSchedule.forEach(element => {

            $(".modal-body #" + element.sscName ).val(element.sscValue);
            $(".modal-body #" + element.sscName ).attr("sscId", element.sscId);
        });

        var dateRang = convertDateToHuman(resp.response.settingScheduleGroup.ssgDateStart) + " - " + convertDateToHuman(resp.response.settingScheduleGroup.ssgDateEnd);
        console.log(dateRang);
        $(".modal-body #scheduleDateRang").val(dateRang);
        $("#modal-createSchedule").modal();
    },"json");
});

$("#deleteButtonConfirm").click(function(){

    // check this schedule is working
    if($(this).attr("class").search("disabled") != -1){

        $("#modal-deleteConfirm").modal("hide");
        $.post(base_url + "/General/getLangLine", {"str": "generalScheduleLock"}, function(resp){

            modalMessage(resp.response);
        },"json");

        // Stop this function
        return true;
    }

    var ssgId = $(this).data("id");
    $.post(base_url + "/System/Setting/deleteSettingSchedule", {"ssgId" : ssgId}, function(resp){

        $("#modal-deleteConfirm").modal("hide");
        loadScheduleTable(currentPage, limitPage, "");
    });
});


// Definition

function loadSettingDefault(){
    $.post(base_url + "/System/Setting/getSetting", {}, function(json){

        json.response.forEach(element => {
            
            $("#" + element.sedName ).val(element.sedValue);
            $("#" + element.sedName ).attr("sedId", element.sedId);
        });
    }, "json");
}

function loadScheduleTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/System/Setting/getSettingScheduleList", json, function(resp){

        var columnTemplate = $("#rowTemplateSchedule tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", "13");
        }
        resp.response.dataList.forEach(function(row){

            if(row.isLock){

                disabled = "disabled";
            }else{

                disabled = "";
            }
            replace = {
                "{ssgId}"               : row.ssgId,
                "{no}"                  : no + 1,
                "{dateStart}"           : convertDateToHuman(row.dateStart),
                "{dateEnd}"             : convertDateToHuman(row.dateEnd),
                "{moneyToPoint}"        : row.moneyToPoint,
                "{pointToMoneyLevel-S}" : row.pointToMoneyLevelS,
                "{pointToMoneyLevel-L}" : row.pointToMoneyLevelL,
                "{tax}"                 : row.tax,
                "{S-Fee}"               : row.sFee,
                "{L-Fee}"               : row.lFee,
                "{pounderWeight}"       : row.pounderWeight,
                "{commission}"          : row.commission,
                "{refer}"               : row.refer,
                "{standardPoint}"       : row.standardPoint,
                "{disabled}"            : disabled
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyScheduleList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);
    },"json");
}

function loadHistoryTable(currentPage, limitPage, search){

    var json = {
        "currentPage" : currentPage,
        "limitPage" : limitPage,
        "search" : search
    };
    $.post(base_url + "/System/Setting/getSettingHistory", json, function(resp){

        var columnTemplate = $("#rowTemplateHistory tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        if(!resp.response.dataList.length){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", "13");
        }
        resp.response.dataList.forEach(function(row){

            replace = {
                "{no}"                  : no + 1,
                "{date}"                : convertDateToHuman(row.dateStart),
                "{moneyToPoint}"        : row.moneyToPoint,
                "{pointToMoneyLevel-S}" : row.pointToMoneyLevelS,
                "{pointToMoneyLevel-L}" : row.pointToMoneyLevelL,
                "{tax}"                 : row.tax,
                "{S-Fee}"               : row.sFee,
                "{L-Fee}"               : row.lFee,
                "{pounderWeight}"       : row.pounderWeight,
                "{commission}"          : row.commission,
                "{refer}"               : row.refer,
                "{standardPoint}"       : row.standardPoint
            }
            no++;
            tbody += replaceAll(columnTemplate, replace);
        });
        $("#tbodyHistoryList").html(tbody);

        // pagination
        var pagination = genPagination(resp.response.pagination);
        $(".paginationList").html(pagination);
    },"json");
}



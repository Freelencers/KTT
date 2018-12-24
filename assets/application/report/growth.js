// On load

loadTable();

// on action

// defination

function loadTable(currentPage, limitPage, search){

    $.post(base_url + "/Report/Growth/getGrowthList", {}, function(resp){

        var columnTemplate = $("#templateGrowth tbody").html();
        var no = (currentPage - 1) * limitPage;
        var tbody = "";
        var avg = 0;
        
        if(!resp.response.dataList){

            tbody = $("#noDataRow tbody").html();
            tbody = tbody.replace("{colspan}", 15);
        }

        for (var key in resp.response.dataList) {

            replace = {
                "{code}" : resp.response.dataList[key].code,
                "{fanshineName}" : resp.response.dataList[key].fullName
            }

            avg = 0;
            for(var i=1;i<=12;i++){

                if(resp.response.dataList[key].incomeOfMonth[i] == undefined){

                    replace["{m" + i + "}"] = 0;
                }else{

                    replace["{m" + i + "}"] = resp.response.dataList[key].incomeOfMonth[i];
                }

                avg += parseFloat(replace["{m" + i + "}"]);
                console.log(replace["{m" + i + "}"]);
            }

            replace["{avg}"] = Math.round((avg / 12) * 100) / 100;

            //console.log(replace);
            tbody += replaceAll(columnTemplate, replace);
        }
        $("#tableOfgrowth").html(tbody);
    },"json");
}

// On load
var currentPage = 1;
var currentPageMaterial = 1;
var limitPage = 10;

// on action


// Create button click



// Definition


function loadCustomerList(code){

    var json = {
        "currentPage" : 1,
        "limitPage" : 1000,
        "search" : code 
    };
    $.post(base_url + "/Fanshine/Customer/getCustomerList", json, function(resp){
        // Location
        var optionTemplate = $("#option").html();
        var options = "";
        if(!resp.response.dataList.length){

            options = $("#option").html();
            options = option.replace("{title}", "No Data");
        }

        // Auto Mode option
        replace = {
           "{title}" : "Select Customer",
           "{value}" : 0
       }
       options += replaceAll(optionTemplate, replace);

       resp.response.dataList.forEach(function(row){

            replace = {
                "{title}" : row.locName + " - " + row.stoVirtualStock + " " + row.untName,
                "{value}" : row.locId
            }
            options += replaceAll(optionTemplate, replace);
        });
        $(".matLocStock").html(options);

    });
}

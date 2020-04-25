$(document).ready(function () {
    //Fiscal Year
    //from date
    $('#from_date_bs').nepaliDatePicker({
        dateFormat: "%y-%m-%d",
        closeOnDateSelect: true
    });

    $("#from_date_bs").bind("dateChange change", function (event) {
        var date = $("#from_date_bs").val().split(/[-/]+/);
        var bs = calendarFunctions.getAdDateByBsDate(parseInt(date[0]), parseInt(date[1]), parseInt(date[2]));
        var bsDate = bs2adDate(bs);
        $('#from_date_ad').val(bsDate);
    });

    $('#from_date_ad').change(function (event) {
        var date = new Date($(this).val());
        var res = calendarFunctions.getBsDateByAdDate(date.getFullYear(), date.getMonth() + 1, date.getDate());
        var formatedNepaliDate = calendarFunctions.bsDateFormat("%y-%m-%d", res.bsYear, res.bsMonth, res.bsDate);
        $('#from_date_bs').val(formatedNepaliDate);
    });

    //to Date
    $('#to_date_bs').nepaliDatePicker({
        dateFormat: "%y-%m-%d",
        closeOnDateSelect: true
    });

    $("#to_date_bs").bind("dateChange change", function (event) {
        var date = $("#to_date_bs").val().split(/[-/]+/);
        var bs = calendarFunctions.getAdDateByBsDate(parseInt(date[0]), parseInt(date[1]), parseInt(date[2]));
        var bsDate = bs2adDate(bs);
        $('#to_date_ad').val(bsDate);
    });

    $('#to_date_ad').change(function (event) {
        var date = new Date($(this).val());
        var res = calendarFunctions.getBsDateByAdDate(date.getFullYear(), date.getMonth() + 1, date.getDate());
        var formatedNepaliDate = calendarFunctions.bsDateFormat("%y-%m-%d", res.bsYear, res.bsMonth, res.bsDate);
        $('#to_date_bs').val(formatedNepaliDate);
    });



    //convert bs to ad
    function bs2adDate(ad) {
        var date = new Date(ad),
            mnth = ("0" + (date.getMonth() + 1)).slice(-2),
            day = ("0" + date.getDate()).slice(-2);

        return [date.getFullYear(), mnth, day].join("-");
    }
});
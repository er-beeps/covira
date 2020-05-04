function changeLatDecimalToDegree() {
    var decimal = parseFloat($('#gps_lat').val());
    $('#gps_lat_degree').val(getDegrees(decimal));
    $('#gps_lat_minute').val(getMinutes(decimal));
    $('#gps_lat_second').val(getSeconds(decimal));
}

function changeLongDecimalToDegree() {
    var decimal = parseFloat($('#gps_long').val());
    $('#gps_long_degree').val(getDegrees(decimal));
    $('#gps_long_minute').val(getMinutes(decimal));
    $('#gps_long_second').val(getSeconds(decimal));
}


//Convert degree-minute-second to decimal
$('#gps_lat_degree, #gps_lat_minute, #gps_lat_second').on('keyup', function () {
    var degree = parseInt($('#gps_lat_degree').val());
    var minute = parseInt($('#gps_lat_minute').val());
    var second = parseInt($('#gps_lat_second').val());
    $('#gps_lat').val(ConvertDMSToDD(degree, minute, second));
});

$('#gps_long_degree, #gps_long_minute, #gps_long_second').on('keyup', function () {
    var degree = parseInt($('#gps_long_degree').val());
    var minute = parseInt($('#gps_long_minute').val());
    var second = parseInt($('#gps_long_second').val());
    $('#gps_long').val(ConvertDMSToDD(degree, minute, second));
});

// Convert decimal to degree-minute-second
$('#gps_lat').on('keyup', function () {
    changeLatDecimalToDegree();
    // updateMarkerByInputs();
});


$('#gps_long').on('keyup', function () {
    changeLongDecimalToDegree();
    // updateMarkerByInputs();

});
function ConvertDMSToDD(degree, minute, second) {
    var dd = (degree + (minute / 60) + (second / (60 * 60))).toFixed(7);
    return dd;
}

function getDegrees(decimal) {
    var absolute = Math.abs(decimal);
    var degrees = Math.floor(absolute);

    return degrees;
}

function getMinutes(decimal) {
    var absolute = Math.abs(decimal);

    var degrees = Math.floor(absolute);
    var minutesNotTruncated = (absolute - degrees) * 60;
    var minutes = Math.floor(minutesNotTruncated);

    return minutes;
}

function getSeconds(decimal) {
    var absolute = Math.abs(decimal);

    var degrees = Math.floor(absolute);
    var minutesNotTruncated = (absolute - degrees) * 60;
    var minutes = Math.floor(minutesNotTruncated);
    var seconds = Math.round((minutesNotTruncated - minutes) * 60);

    return seconds;
}

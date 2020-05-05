var map = L.map("map", {
    closePopupOnClick: false,
    maxZoom: 18,
    fullscreenControl: true

}).setView([28.253007, 83.938548], 6);
map.on('layeradd', function(event) {
    var layer = event.layer;
    if (layer instanceof L.Marker && !(layer instanceof L.MarkerCluster)) {
        layer.closePopup();
    }
});
var mcg = L.markerClusterGroup();
var markers = [];
for (var x in json) {

    var lat = json[x].lat;
    lng = json[x].lon;
    name = json[x].name;
    id = json[x].id;
    xform_id = json[x].xform_id;
    wards = json[x].ward;
    mobile = json[x].mobile;
    tole_name = json[x].tole_name;
    house_no = json[x].house_no;
    device_id = json[x].device_id;
    var ward = wards.replace("ward_", '');
    var url = '/app/gis/search/' + xform_id + '/' + id;
    marker = new L.marker([lat, lng]).addTo(mcg).bindPopup('नाम: ' + '<font color="red">' + name + '</font>' + '<br>' +
        'घर नं: ' + '<font color="red">' + house_no + '</font>' + '<br>' +
        'फोन नं: ' + '<font color="red">' + mobile + '</font>' + '<br>' +
        'वार्ड नं: ' + '<font color="red">' + ward + '</font>' + '<br>' +
        'टोल नं: ' + '<font color="red">' + tole_name + '</font>' + '<br>' +
        '<a href="' + url + '"><i class="fa fa-eye"></i>View profile</a>' + '<br>' +
        '<b><font color="green">Collected by:</font></b>' + '<br>' +
        'Device Id: ' + '<font color="red">' + device_id + '</font>' + '<br>', {
            autoClose: false,
            autoPan: false
        },

    );


}

mcg.addTo(map);



L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
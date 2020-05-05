var map = L.map("map", {
    closePopupOnClick: false,
    maxZoom: 20,
    fullscreenControl: true

}).setView([27.700769, 85.300140], 6);
map.on('layeradd', function (event) {
    var layer = event.layer;
    if (layer instanceof L.Marker && !(layer instanceof L.MarkerCluster)) {
        layer.closePopup();
    }
});
var mcg = L.markerClusterGroup();
var markers = [];

// var firefoxIcon = L.icon({iconUrl:'/gismap/icons/ROAD.png',iconSize:[20, 25]});

for (var x in json) {
    var lat = json[x].lat;
    lng = json[x].lon;
    name_en = json[x].name_en;
    name_lc = json[x].name_lc;
    icons = json[x].icon;
    id = json[x].id;
    locallevel = json[x].locallevel;
    district = json[x].district_name_np;

    // var url='/gismap/icons/ROAD.png';
    var url = '/gismap/icons/' + icons + '.png';
    var firefoxIcon = L.icon({ iconUrl: url, iconSize: [20, 25] });
    if (lat !== null) {
        marker = new L.marker([lat, lng], { icon: firefoxIcon }).addTo(mcg).bindPopup('कोड: ' + '<font color="red">' + code + '</font>' + '<br>' +
            'नाम: ' + '<font color="green">' + name_en + '</font>' + '<br>' +
            'जिल्ला: ' + '<font color="green">' + district + '</font>' + '<br>' +
            'स्थानीय तह: ' + '<font color="blue">' + locallevel + '</font>' + '<br>' +
            '<a href="' + detail + '" target="_blank"><i class="fa fa-eye"></i>View Details</a>' + '<br>',

            {
                autoClose: true,
                autoPan: false
            }

        );
    }
}




// create marker object, pass custom icon as option, add to map

mcg.addTo(map);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
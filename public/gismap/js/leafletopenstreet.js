var map = L.map(document.getElementById('map'), {
    closePopupOnClick: false,
    maxZoom: 20,
    zoomSnap: 0.10,
    fullscreenControl: true

}).setView([28.45, 83.50], 6.8);
map.on('layeradd', function (event) {
    var layer = event.layer;
    if (layer instanceof L.Marker && !(layer instanceof L.MarkerCluster)) {
        layer.closePopup();
    }
});
var mcg = L.markerClusterGroup(
    {
        spiderfyOnMaxZoom: true,
        showCoverageOnHover: true,
        zoomToBoundsOnClick: true
    }
);
var markers = [];

for (var x in json) {
    var lat = json[x].lat;
    lng = json[x].lon;
    code = json[x].code;
    name_en = json[x].name_en;
    name_lc = json[x].name_lc;
    locallevel = json[x].locallevel;
    district = json[x].district_name_np;
    cri =json[x].covid_risk_index;

    if(cri >0 && cri < 20){
        url = '/gismap/icons/verylow.png';
    }else if(cri > 20 && cri <= 40){
        url = '/gismap/icons/low.png';
    }else if(cri > 40 && cri <= 60){
        url = '/gismap/icons/moderate.png';
    }else if(cri > 60 && cri <= 80){
        url = '/gismap/icons/high.png';
    }else if(cri = 80){
        url = '/gismap/icons/veryhigh.png';
    }


    var url = url;
    var firefoxIcon = L.icon({ iconUrl: url, iconSize: [12, 12] });

    if (lat !== null) {
        marker = new L.marker([lat, lng], { icon: firefoxIcon }).addTo(mcg).bindPopup('कोड: ' + '<font color="red">' + code + '</font>' + '<br>' +
            'जिल्ला: ' + '<font color="orange">' + district + '</font>' + '<br>' +
            'स्थानीय तह: ' + '<font color="blue">' + locallevel + '</font>' + '<br>',
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
    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a>'
}).addTo(map);
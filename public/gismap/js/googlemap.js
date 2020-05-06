function initMap() {
    var map1 = new google.maps.Map(document.getElementById('map1'), {
        center: new google.maps.LatLng(28.35, 84.25),
        zoom: 7
    });

    var infowindow = new google.maps.InfoWindow();
    var oms = new OverlappingMarkerSpiderfier(map1, {
        markersWontMove: true,
        markersWontHide: true,
        basicFormatEvents: true
    });
    var markers = [];
    for (var x in json) {
        var lat = json[x].lat;
        lng = json[x].lon;
        code = json[x].code;
        name_en = json[x].name_en;
        name_lc = json[x].name_lc;
        locallevel = json[x].locallevel;
        district = json[x].district_name_np;

        var icon = {
            url: '/gismap/icons/person.png', // url
            scaledSize: new google.maps.Size(12, 12), // scaled size
        };

        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            name: name,
            map: map1,
            icon: icon,
            content: 'कोड: ' + '<font color="red">' + code + '</font>' + '<br>' +
                'जिल्ला: ' + '<font color="orange">' + district + '</font>' + '<br>' +
                'स्थानीय तह: ' + '<font color="blue">' + locallevel + '</font>'

        });

        google.maps.event.addListener(marker, 'spider_click', function (e) {
            infowindow.setContent(this.content);
            infowindow.open(map1, this);
        }.bind(marker));

        oms.addMarker(marker);
        markers.push(marker);
    }
    var markerCluster = new MarkerClusterer(map1, markers, {
        imagePath: '/gismap/images/m',
        minimumClusterSize: 2
    }

    );


}
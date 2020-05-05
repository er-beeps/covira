function initMap() {
    var map1 = new google.maps.Map(document.getElementById('map1'), {
        center: new google.maps.LatLng(27.700769, 85.300140),
        zoom: 6
    });

    var infowindow = new google.maps.InfoWindow();

    var oms = new OverlappingMarkerSpiderfier(map1, {
        markersWontMove: true,
        markersWontHide: true,
        basicFormatEvents: true
    });
    var markers = [];
    for (var x in json) {
        lat = json[x].lat;
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
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            name: name,
            map: map1,
            content: 'नाम: ' + '<font color="red">' + name + '</font>' + '<br>' +
                'घर नं: ' + '<font color="red">' + house_no + '</font>' + '<br>' +
                'फोन नं: ' + '<font color="red">' + mobile + '</font>' + '<br>' +
                'वार्ड नं: ' + '<font color="red">' + ward + '</font>' + '<br>' +
                'टोल नं: ' + '<font color="red">' + tole_name + '</font>' + '<br>' +
                '<a href="' + url + '"><i class="fa fa-eye"></i>View profile</a>' + '<br>' +
                '<b><font color="green">Collected by:</font></b>' + '<br>' +
                'Device Id: ' + '<font color="red">' + device_id + '</font>' + '<br>'
        });
        google.maps.event.addListener(marker, 'spider_click', function(e) {
            infowindow.setContent(this.content);
            infowindow.open(map1, this);
        }.bind(marker));
        oms.addMarker(marker);
        markers.push(marker);
    }

    var markerCluster = new MarkerClusterer(map1, markers, {
            zoomOnClick: true,

            imagePath: '/gismap/images/m',
            minimumClusterSize: 10

        },
        infowindow
    );

}
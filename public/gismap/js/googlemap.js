function initMap() {
    var map1 = new google.maps.Map(document.getElementById('map1'), {
        center: new google.maps.LatLng(28.35, 84.25),
        zoom: 6.8
    });

    var infowindow = new google.maps.InfoWindow();
    var oms = new OverlappingMarkerSpiderfier(map1, {
        markersWontMove: true,
        markersWontHide: true,
        basicFormatEvents: true,
        keepSpiderfied: true,
        circleSpiralSwitchover: 2
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
        ward = json[x].ward_number;
        is_other_country = json[x].is_other_country;
        country_en = json[x].country_name_en;
        country_lc = json[x].country_name_lc;
        capital_en = json[x].capital_name_en;
        capital_lc = json[x].capital_name_lc;
        city = json[x].city;
        ari = json[x].age_risk_factor;
        cri = json[x].covid_risk_index;
        pci = json[x].probability_of_covid_infection;


        if (cri >= 0 && cri < 20) {
            url = '/gismap/icons/verylow.png';
            cri_data = 'Very Low';
            color_cri = 'green';
        } else if (cri > 20 && cri <= 40) {
            url = '/gismap/icons/low.png';
            cri_data = 'Low';
            color_cri = '#10b552';
        } else if (cri > 40 && cri <= 60) {
            url = '/gismap/icons/moderate.png';
            cri_data = 'Moderate';
            color_cri = 'yellow';
        } else if (cri > 60 && cri <= 80) {
            url = '/gismap/icons/high.png';
            cri_data = 'High';
            color_cri = 'orange';
        } else if (cri > 80) {
            color_cri = 'red';
            url = '/gismap/icons/veryhigh.png';
            cri_data = 'Very High';
        }

        if (pci >= 0 && pci < 20) {
            color_pci = 'green';
            pci_data = 'Very Low';
        } else if (pci > 20 && pci <= 40) {
            pci_data = 'Low';
            color_pci = '#10b552';
        } else if (pci > 40 && pci <= 60) {
            pci_data = 'Moderate';
            color_pci = 'yellow';
        } else if (pci > 60 && pci <= 80) {
            pci_data = 'High';
            color_pci = 'orange';
        } else if (pci > 80) {
            pci_data = 'Very High';
            color_pci = 'red';
        }


        var icon = {
            url: url, // url
            scaledSize: new google.maps.Size(13, 13), // scaled size
        };

        if (is_other_country === false) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                name: name,
                map: map1,
                icon: icon,
                content: '<font color="#003399">जिल्ला : </font>' + '<font color="purple">' + district + '</font>' + '<br>' +
                    '<font color="#003399">स्थानीय तह : </font>' + '<font color="purple">' + locallevel + '</font>' + '<br>' +
                    '<font color="#003399">COVID Risk Index : </font>' + '<b><font color="' + color_cri + '">' + cri_data + '</font></b>' + '<br>' +
                    '<font color="#003399">Probability of COVID Infection : </font>' + '<b><font color="' + color_pci + '">' + pci_data + '</font></b>'

            });
        } else {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                name: name,
                map: map1,
                icon: icon,
                content: '<font color="#003399">Country : </font>' + '<font color="purple">' + country_en + '</font>' + '<br>' +
                    '<font color="#003399">Capital  : </font>' + '<font color="purple">' + capital_en + '</font>' + '<br>' +
                    '<font color="#003399">City  : </font>' + '<font color="purple">' + city + '</font>' + '<br>' +
                    '<font color="#003399">COVID Risk Index : </font>' + '<b><font color="' + color_cri + '">' + cri_data + '</font></b>' + '<br>' +
                    '<font color="#003399">Probability of COVID Infection : </font>' + '<b><font color="' + color_pci + '">' + pci_data + '</font></b>'

            });

        }

        google.maps.event.addListener(marker, 'spider_click', function (e) {
            infowindow.setContent(this.content);
            infowindow.open(map1, this);
        }.bind(marker));

        oms.addMarker(marker);
        markers.push(marker);
    }
    var markerCluster = new MarkerClusterer(map1, markers, {
        imagePath: '/gismap/images/m',
        minimumClusterSize: 100,
    }

    );


}
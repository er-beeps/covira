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
        ari =json[x].age_risk_factor;
        cri =json[x].covid_risk_index;
        pci =json[x].probability_of_covid_infection;

        if(cri >=0 && cri < 20){
            url = '/gismap/icons/verylow.png';
            color_cri = 'green';
        }else if(cri > 20 && cri <= 40){
            url = '/gismap/icons/low.png';
            color_cri= '#10b552';
        }else if(cri > 40 && cri <= 60){
            url = '/gismap/icons/moderate.png';
            color_cri= 'yellow';
        }else if(cri > 60 && cri <= 80){
            url = '/gismap/icons/high.png';
            color_cri='orange';
        }else if(cri > 80){
            color_cri='red';
            url = '/gismap/icons/veryhigh.png';
        }else{
            color_cri = 'null';
            url = '/gismap/icons/person.png';

        }

        if(pci >=0 && pci < 20){ 
            color_pci = 'green';
        }else if(pci > 20 && pci <= 40){
            color_pci= '#10b552';
        }else if(pci > 40 && pci <= 60){
            color_pci= 'yellow';
        }else if(pci > 60 && pci <= 80){
            color_pci='orange';
        }else if(pci > 80){
            color_pci='red';
        }else{
            color_pci = 'black';
        }


        var icon = {
            url: url, // url
            scaledSize: new google.maps.Size(13, 13), // scaled size
        };

        marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            name: name,
            map: map1,
            icon: icon,
            content: '<font color="#003399">जिल्ला : </font>' + '<font color="purple">' + district + '</font>' + '<br>' +
                    '<font color="#003399">स्थानीय तह : </font>' + '<font color="purple">' + locallevel + ' - '+ ward + '</font>'+ '<br>' +
                    '<font color="#003399">COVID Risk Index : </font>' + '<b><font color="'+color_cri+'">' + cri + '</font></b>'+ '<br>' +
                    '<font color="#003399">Probability of COVID Infection : </font>' + '<b><font color="'+color_pci+'">' + pci + '</font></b>'

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
        minimumClusterSize: 10
    }

    );


}
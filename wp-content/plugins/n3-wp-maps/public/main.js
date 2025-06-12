var map;
var Data = [];
var viewportMarkers = [];
var infoWindow;
var handle1, handle2;
var markerCount = 0;

// Function to initialize the map and set values										
function initMap() {
    var lat = 35.414722;
    var lng = -97.386667;
    var iniZoom = 9;
    var myLatLng = new google.maps.LatLng(lat, lng);

    var options = {
        zoom: iniZoom,
        center: myLatLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    map = new google.maps.Map(document.getElementById('nguyenmapinit'), options);

    // Add event listeners for when the map has changed: drag, zoom in/out or page refreshed.
    google.maps.event.addListener(map, 'dragend', function () {
        showMarkersInViewport()
    });
    google.maps.event.addListener(map, 'idle', function () {
        showMarkersInViewport()
    });
}

// Create a function to add markers to the map. 
function showMarkersInViewport() {
    if (viewportMarkers != null) {
        for (i = 0; i < viewportMarkers.length; i++) {
            viewportMarkers[i].setMap(null);
        }
        viewportMarkers = [];

        // close any open infoWindows when the map is clicked
        google.maps.event.addListener(map, "click", function () {
            infoWindow.close();
        });

        // Set the results box row color back to normal when the map is clicked
        google.maps.event.addListener(map, 'click', function selectDataRow(code) {
            var table = document.getElementById("tbl");
            for (var i = 1, row; row = table.rows[i]; i++) {
                row.style.backgroundColor = "#ffffff";
            }
        });
    }

    // Create a table to hold the info of the markers on the map.
    var divTable = '<div class="maplist">'

    // call the getAirports() function to retrieve the locations (nguyenmaps) in the current viewport.
    var nguyenmapsInViewport = getAirports(map.getBounds());
    if (nguyenmapsInViewport == null) return;
    //   3. Add a new row to the table beside the map that summarizes the nguyenmaps on the map
    for (i = 0; i < nguyenmapsInViewport.length; i++) {
        // create a new marker
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(nguyenmapsInViewport[i].Location.Latitude, nguyenmapsInViewport[i].Location.Longitude),
            icon: nguyenmapsInViewport[i].icon,
            title: nguyenmapsInViewport[i].Name
        });
        var html = '';
        html += '';
            if(nguyenmapsInViewport[i].URL !== null && nguyenmapsInViewport[i].URL !== '') {
                html +='<div style="margin-bottom:5px; font-size: 1.3rem"><a href="' + nguyenmapsInViewport[i].URL + '" target="_blank"><b>Name: </b>' + nguyenmapsInViewport[i].Name + '</a></div>';
            } else {
                html +='<div style="margin-bottom:5px"><b>Name: </b>' + nguyenmapsInViewport[i].Name + '</div>';
            }
            if(nguyenmapsInViewport[i].Photo !== null && nguyenmapsInViewport[i].Photo !== '') {
                html += '<div style="margin-bottom:5px"><img style="max-width:100%;max-height: 80px" src="' + nguyenmapsInViewport[i].Photo + '" /></div>';
            }
            if(nguyenmapsInViewport[i].City !== null && nguyenmapsInViewport[i].City !== '') {
                html += '<div style="margin-bottom:5px"><b>City: </b>' + nguyenmapsInViewport[i].City + '</div>';
            }
            if(nguyenmapsInViewport[i].State !== null && nguyenmapsInViewport[i].State !== '') {
                html += '<div style="margin-bottom:5px"><b>State: </b>' + nguyenmapsInViewport[i].State + '</div>';
            }
            if(nguyenmapsInViewport[i].Country !== null && nguyenmapsInViewport[i].Country !== '') {
                html += '<div style="margin-bottom:5px"><b>Country: </b>' + nguyenmapsInViewport[i].Country + '</div>';
            }

        marker.objInfo = html;

        // add the click event's listener for each marker to open the info-Window
        (function (index, selectedMarker) {
            google.maps.event.addListener(selectedMarker, 'click', function () {
                if (infoWindow != null) infoWindow.setMap(null);
                infoWindow = new google.maps.InfoWindow();
                infoWindow.setContent(selectedMarker.objInfo);
                infoWindow.open(map, selectedMarker);
                selectDataRow(nguyenmapsInViewport[index].Code)
            });
        })(i, marker)

        // place the marker on the map 
        marker.setMap(map);
        // add the marker to the viewportMarkers array
        viewportMarkers.push(marker);
        // Create a new row entry for the table corresponding to the current airport
        var currentIndex = viewportMarkers.length - 1;
        // Finally, add the <tr> element for the row 
        divTable += '<div class="item" id="mapid' + nguyenmapsInViewport[i].Code + '">' +
            '<h4 class="maphead">' +
            '<a href="javascript:highlightMarker(' + currentIndex + ')">' +
            nguyenmapsInViewport[i].Name +
            '</a></h4>' + 
            '<div class="maplocation">' +
            nguyenmapsInViewport[i].City +
            nguyenmapsInViewport[i].State +
            '</div></div>'
        markerCount++;
    }
    divTable += '</div>'
    document.getElementById('nguyenmapmenu').innerHTML = divTable;
}

// Function to change the row background color when the corresponding marker is clicked.
function selectDataRow(code) {
    var table = document.getElementById("nguyenmapmenu");
    table.querySelectorAll('.item').forEach(function (item) {
        if (item.id == 'mapid' + code) {
            item.classList.add('active');
        } else {
            item.classList.remove('active');
        }
    });
}

function getAirports(a) {
    if (a == null || a == undefined) return null;
    var selected = [];
    for (i = 0; i < nguyenmaps.length; i++) {
        if (a.contains(new google.maps.LatLng(nguyenmaps[i].Location.Latitude, nguyenmaps[i].Location.Longitude))) {
            selected.push(nguyenmaps[i]);
        }
    }
    return selected;
}

//  The highlightMarker() function opens the InfoWindow object that corresponds
//  to the marker in the viewportMarkers array

function highlightMarker(index) {
    if (infoWindow != null) infoWindow.setMap(null);
    infoWindow = new google.maps.InfoWindow();
    infoWindow.setContent(viewportMarkers[index].objInfo);
    infoWindow.open(map, viewportMarkers[index]);

    // Bounce the marker for two seconds when the corresonding link is clicked in the result box.				
    viewportMarkers[index].setAnimation(google.maps.Animation.BOUNCE);
    setTimeout(function () {
        viewportMarkers[index].setAnimation(null);
    }, 1250); // This sets the time for the bounce. You can make it longer or shorter. 
}
// Pan the map to center the marker when the "CODE" link is clicked in the results box.   
function zoomMarker(index) {
    map.panTo(viewportMarkers[index].getPosition());

}
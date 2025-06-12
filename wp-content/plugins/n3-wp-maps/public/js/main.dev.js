"use strict";

var map;
var Data = [];
var viewportMarkers = [];
var infoWindow;
var handle1, handle2;
var markerCount = 0; 

function initMap() {
  var lat = 35.414722;
  var lng = -97.386667;
  var iniZoom = 9;
  var myLatLng = new google.maps.LatLng(lat, lng);
  var options = {
    zoom: iniZoom,
    center: myLatLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById('nguyenmapinit'), options); 

  google.maps.event.addListener(map, 'dragend', function () {
    showMarkersInViewport();
  });
  google.maps.event.addListener(map, 'idle', function () {
    showMarkersInViewport();
  });
} 


function showMarkersInViewport() {
  if (viewportMarkers != null) {
    for (i = 0; i < viewportMarkers.length; i++) {
      viewportMarkers[i].setMap(null);
    }

    viewportMarkers = []; 

    google.maps.event.addListener(map, "click", function () {
      infoWindow.close();
    }); 

    google.maps.event.addListener(map, 'click', function selectDataRow(code) {
      var table = document.getElementById("tbl");

      for (var i = 1, row; row = table.rows[i]; i++) {
        row.style.backgroundColor = "#ffffff";
      }
    });
  } 


  var divTable = '<div class="maplist">'; 

  var nguyenmapsInViewport = getAirports(map.getBounds());
  if (nguyenmapsInViewport == null) return; 

  for (i = 0; i < nguyenmapsInViewport.length; i++) {
    
    var marker = new google.maps.Marker({
      position: new google.maps.LatLng(nguyenmapsInViewport[i].Location.Latitude, nguyenmapsInViewport[i].Location.Longitude),
      icon: nguyenmapsInViewport[i].icon,
      title: nguyenmapsInViewport[i].Name
    });
    var html = '';
    html += '';

    if (nguyenmapsInViewport[i].URL !== null && nguyenmapsInViewport[i].URL !== '') {
      html += '<div style="margin-bottom:5px; font-size: 1.3rem"><a href="' + nguyenmapsInViewport[i].URL + '" target="_blank"><b>Name: </b>' + nguyenmapsInViewport[i].Name + '</a></div>';
    } else {
      html += '<div style="margin-bottom:5px"><b>Name: </b>' + nguyenmapsInViewport[i].Name + '</div>';
    }

    if (nguyenmapsInViewport[i].Photo !== null && nguyenmapsInViewport[i].Photo !== '') {
      html += '<div style="margin-bottom:5px"><img style="max-width:100%;max-height: 80px" src="' + nguyenmapsInViewport[i].Photo + '" /></div>';
    }

    if (nguyenmapsInViewport[i].City !== null && nguyenmapsInViewport[i].City !== '') {
      html += '<div style="margin-bottom:5px"><b>City: </b>' + nguyenmapsInViewport[i].City + '</div>';
    }

    if (nguyenmapsInViewport[i].State !== null && nguyenmapsInViewport[i].State !== '') {
      html += '<div style="margin-bottom:5px"><b>State: </b>' + nguyenmapsInViewport[i].State + '</div>';
    }

    if (nguyenmapsInViewport[i].Country !== null && nguyenmapsInViewport[i].Country !== '') {
      html += '<div style="margin-bottom:5px"><b>Country: </b>' + nguyenmapsInViewport[i].Country + '</div>';
    }

    marker.objInfo = html; 

    (function (index, selectedMarker) {
      google.maps.event.addListener(selectedMarker, 'click', function () {
        if (infoWindow != null) infoWindow.setMap(null);
        infoWindow = new google.maps.InfoWindow();
        infoWindow.setContent(selectedMarker.objInfo);
        infoWindow.open(map, selectedMarker);
        selectDataRow(nguyenmapsInViewport[index].Code);
      });
    })(i, marker); 


    marker.setMap(map); 

    viewportMarkers.push(marker); 

    var currentIndex = viewportMarkers.length - 1; 

    divTable += '<div class="item" id="mapid' + nguyenmapsInViewport[i].Code + '">' + '<h4 class="maphead">' + '<a href="javascript:highlightMarker(' + currentIndex + ')">' + nguyenmapsInViewport[i].Name + '</a></h4>' + '<div class="maplocation">' + nguyenmapsInViewport[i].City + nguyenmapsInViewport[i].State + '</div></div>';
    markerCount++;
  }

  divTable += '</div>';
  document.getElementById('nguyenmapmenu').innerHTML = divTable;
} 


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



function highlightMarker(index) {
  if (infoWindow != null) infoWindow.setMap(null);
  infoWindow = new google.maps.InfoWindow();
  infoWindow.setContent(viewportMarkers[index].objInfo);
  infoWindow.open(map, viewportMarkers[index]); 

  viewportMarkers[index].setAnimation(google.maps.Animation.BOUNCE);
  setTimeout(function () {
    viewportMarkers[index].setAnimation(null);
  }, 1250); 
} 


function zoomMarker(index) {
  map.panTo(viewportMarkers[index].getPosition());
}
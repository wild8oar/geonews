function addStationsFromDb(username) {
  $.getJSON("api.php?username=" + encodeURIComponent(username), function(data) {
    if(data.length == 0) {
      $("#no-gpx").show();
    } else {
      showMapAndPrintMarkers(data);
    }
  });
}

function addRecentStationsFromDb(username) {
  $.getJSON("api.php?username=" + encodeURIComponent(username) + "&recent=true", function(data) {
    if(data.length != 0) {
      showMapAndPrintMarkers(data);
    }
  });
}

function showMapAndPrintMarkers(obj) {
  var map = getMap('map');
  var markerBounds = new google.maps.LatLngBounds();

  $("#map").show();
  obj.forEach(function(geocache) {
    var point = new google.maps.LatLng(geocache.lat, geocache.lon);
    addMarkerAndFitBounds(point, map, markerBounds, geocache.name, geocache.gc, geocache.type, geocache.created, geocache.url);
    markerBounds.extend(point);
    map.fitBounds(markerBounds);
  });
}

function getMap(id) {
		return new google.maps.Map(document.getElementById(id), {
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			disableDefaultUI: true,
			scrollwheel: true,
			zoomControl: false
		});
}

var infowindow = new google.maps.InfoWindow();

function addMarkerAndFitBounds(point, map, markerBounds, name, gc, type, created, url) {

  var size = new google.maps.Size(25, 25);
  if(window.devicePixelRatio > 1.5){
    size = new google.maps.Size(50, 50);
  }

  var it = {
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  switch(type) {
    case 'Traditional Cache':
      it.url = 'res/icons/traditional.png';
      break;
    case 'Wherigo Cache':
      it.url = 'res/icons/wherigo.png';
      break;
    case 'Unknown Cache':
      it.url = 'res/icons/unknown.png';
      break;
    case 'Virtual Cache':
      it.url = 'res/icons/virtual.png';
      break;
    case 'Multi-cache':
      it.url = 'res/icons/multi.png';
      break;
    case 'Earthcache':
      it.url = 'res/icons/earthcache.png';
      break;
    case 'Letterbox Hybrid':
      it.url = 'res/icons/letterbox.png';
      break;
    case 'Event Cache':
      it.url = 'res/icons/event.gif';
      break;
    case 'Webcam Cache':
      it.url = 'res/icons/webcam.gif';
      break;
    case 'unknown':
      it.url = 'res/icons/unknown.gif';
      break;
  }

  var marker = new google.maps.Marker({
    position: point,
    clickable: true,
    icon: it,
    label: ' ',
    map: map
  });

  marker.addListener('click', function() {
    infowindow.close();
    infowindow.setContent('<div><a href="' + url + '"><b>' + name + '</b></a><br />GC-Code: ' + gc + '<br />Type: ' + type + '<br />Found on: ' + created + '</div>');
    infowindow.setOptions({ pixelOffset: new google.maps.Size(-13, 13) });
    infowindow.open(map, marker);
  });
}

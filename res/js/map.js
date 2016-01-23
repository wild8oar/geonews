function addStationsFromDb(username) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "api.php?username=" + encodeURIComponent(username), true);
  xhr.onload = function(e) {
    var obj = JSON.parse(xhr.responseText);
    if(obj.length == 0) {
      $("#no-gpx").show();
    } else {
      showMapAndPrintMarkers(obj);
    }
  };
  xhr.send(null);
}

function addRecentStationsFromDb(username) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "api.php?username=" + encodeURIComponent(username) + "&recent=true", true);
  xhr.onload = function(e) {
    var obj = JSON.parse(xhr.responseText);
    if(obj.length != 0) {
      showMapAndPrintMarkers(obj);
    }
  };
  xhr.send(null);
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

  var traditional = {
    url: 'res/icons/traditional.png',
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  var multi = {
    url: 'res/icons/multi.png',
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  var wherigo = {
    url: 'res/icons/wherigo.png',
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  var unknown = {
    url: 'res/icons/unknown.png',
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  var virtual = {
    url: 'res/icons/virtual.png',
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  var earth = {
    url: 'res/icons/earthcache.png',
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  var letterbox = {
    url: 'res/icons/letterbox.png',
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  var eventcache = {
    url: 'res/icons/event.gif',
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  var webcam = {
    url: 'res/icons/webcam.gif',
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  var unknownunknown = {
    url: 'res/icons/unknown.gif',
    size: size,
    scaledSize: new google.maps.Size(25, 25),
    origin: new google.maps.Point(0,0),
    anchor: new google.maps.Point(13, 13)
  }

  var it;

  switch(type) {
    case 'Traditional Cache':
      it = traditional;
      break;
    case 'Wherigo Cache':
      it = wherigo;
      break;
    case 'Unknown Cache':
      it = unknown;
      break;
    case 'Virtual Cache':
      it = virtual;
      break;
    case 'Multi-cache':
      it = multi;
      break;
    case 'Earthcache':
      it = earth;
      break;
    case 'Letterbox Hybrid':
      it = letterbox;
      break;
    case 'Event Cache':
      it = eventcache;
      break;
    case 'Webcam Cache':
      it = webcam;
      break;
    case 'unknown':
      it = unknownunknown;
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

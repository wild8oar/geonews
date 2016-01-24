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
  $.getJSON("api.php?username=" + encodeURIComponent(username) + "&mode=recent", function(data) {
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

function geolookup() {
  $.getJSON("api.php?mode=geolookup", function(data) {
    if(data.length != 0) {
      var geocoder = new google.maps.Geocoder;
      data.forEach(function(geocache) {
        var latlng = {lat: geocache.lat, lng: geocache.lon};
          geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === google.maps.GeocoderStatus.OK) {
            if(results[1]) {
              console.log(results[1]);
              var address = results[1].formatted_address;
//              console.log(address);
              console.log('set address of ' + geocache.gc + ' to ' + address);
              $.ajax({
                url: "api.php?mode=save_geolookup&gc=" + encodeURIComponent(geocache.gc) + "&address=" + encodeURIComponent(address)
              });
              if(geocache.country == 'Switzerland') {
                var cantons = [
                  ['Aargau', 'Canton of Aargau'],
                  ['Appenzell-Innerrhoden', 'Appenzell Innerrhoden', 'Appenzell Inner Rhodes'],
                  ['Appenzell-Ausserrhoden', 'Appenzell Ausserrhoden', 'Appenzell Outer Rhodes'],
                  ['Basel-Stadt', 'Basel Stadt'],
                  ['Basel-Landschaft', 'Basel Landschaft'],
                  ['Bern', 'Berne', 'Canton of Bern'],
                  ['Fribourg', 'Freiburg', 'Canton of Fribourg'],
                  ['Geneva', 'Genf', 'Canton of Geneva'],
                  ['Glarus', 'Canton of Glarus'],
                  ['Grisons', 'Graubünden', 'Graubunden', 'Canton of Grisons'],
                  ['Jura', 'Canton of Jura'],
                  ['Lucerne', 'Luzern', 'Canton of Lucerne'],
                  ['Neuchatel', 'Neuenburg', 'Canton of Neuchatel'],
                  ['Nidwalden', 'Canton of Nidwalden'],
                  ['Obwalden', 'Canton of Obwalden'],
                  ['Schaffhausen', 'Canton of Schaffhausen'],
                  ['Schwyz', 'Canton of Schwyz'],
                  ['Solothurn', 'Canton of Solothurn'],
                  ['St. Gallen', 'Saint Gallen', 'Sankt Gallen'],
                  ['Thurgau', 'Canton of Thurgau'],
                  ['Ticino', 'Tessin', 'Canton of Ticino'],
                  ['Uri', 'Canton of Uri'],
                  ['Valais', 'Wallis', 'Canton of Valais'],
                  ['Vaud', 'Waadt', 'Canton of Vaud'],
                  ['Zug', 'Canton of Zug'],
                  ['Zurich', 'Zürich', 'Canton of Zurich']
                ];
                results[1].address_components.forEach(function(entry) {
  //                console.log(entry.long_name);
                  cantons.forEach(function(canton) {
                    var firstCanton = canton[0];
                    if(canton.indexOf(entry.long_name) != -1) {
                      console.log('set canton of ' + geocache.gc + ' to ' + firstCanton);
                      $.ajax({
                        url: "api.php?mode=save_canton&gc=" + encodeURIComponent(geocache.gc) + "&canton=" + encodeURIComponent(firstCanton)
                      })
                    }
                  });
                });
              }
            } else {
              console.log('no results found');
            }
          } else {
            console.log('error, status: ' + status);
          }
        });
      });
      console.log(data);
    }
  });




}

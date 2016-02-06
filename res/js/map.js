function addStationsFromDb(username, countries) {
  $.getJSON("api.php?username=" + encodeURIComponent(username), function(data) {
    if(data.length == 0) {
      $("#no-gpx").show();
    } else {
      showMapAndPrintMarkers(data, countries);
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

function colorizeCountries(map, countries) {
//  console.log(JSON.parse(countries));
  var countriesString = "ISO_2DIGIT IN (";
  JSON.parse(countries).forEach(function(country) {
    countriesString = countriesString + "'" + country + "', "
  });
  countriesString = countriesString.slice(0, -2) + ")";
  var world_geometry = new google.maps.FusionTablesLayer({
      query: {
          from: '1N2LBk4JHwWpOY4d9fobIn27lfnZ5MDy-NoqqRpk',
          where: countriesString
      },
      styles: [{
          polygonOptions: {
              fillColor: '#FFFF00',
              fillOpacity: 0.2
          }
      }],
      map: map,
      suppressInfoWindows: true
  });
}

function showMapAndPrintMarkers(obj, countries) {
  var map = getMap('map');
  var markerBounds = new google.maps.LatLngBounds();

  obj.forEach(function(geocache) {
    var point = new google.maps.LatLng(geocache.lat, geocache.lon);
    addMarker(point, map, markerBounds, geocache.name, geocache.gc, geocache.type, geocache.created, geocache.url);
    markerBounds.extend(point);
  });
  map.fitBounds(markerBounds);
  if(countries != undefined) {
    colorizeCountries(map, countries);
  }
  $("#map").show();
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

function addMarker(point, map, markerBounds, name, gc, type, created, url) {

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
  var districts = new Object();
  districts['Switzerland'] = [
    ['Aargau', 'district of Aargau'],
    ['Appenzell-Innerrhoden', 'Appenzell Innerrhoden', 'Appenzell Inner Rhodes'],
    ['Appenzell-Ausserrhoden', 'Appenzell Ausserrhoden', 'Appenzell Outer Rhodes'],
    ['Basel-Stadt', 'Basel Stadt'],
    ['Basel-Landschaft', 'Basel Landschaft'],
    ['Bern', 'Berne', 'district of Bern'],
    ['Fribourg', 'Freiburg', 'district of Fribourg'],
    ['Geneva', 'Genf', 'district of Geneva', 'Genève'],
    ['Glarus', 'district of Glarus'],
    ['Grisons', 'Graubünden', 'Graubunden', 'district of Grisons'],
    ['Jura', 'district of Jura'],
    ['Lucerne', 'Luzern', 'district of Lucerne'],
    ['Neuchatel', 'Neuenburg', 'district of Neuchatel'],
    ['Nidwalden', 'district of Nidwalden'],
    ['Obwalden', 'district of Obwalden'],
    ['Schaffhausen', 'district of Schaffhausen'],
    ['Schwyz', 'district of Schwyz'],
    ['Solothurn', 'district of Solothurn'],
    ['St. Gallen', 'Saint Gallen', 'Sankt Gallen'],
    ['Thurgau', 'district of Thurgau'],
    ['Ticino', 'Tessin', 'district of Ticino'],
    ['Uri', 'district of Uri'],
    ['Valais', 'Wallis', 'district of Valais'],
    ['Vaud', 'Waadt', 'district of Vaud'],
    ['Zug', 'district of Zug'],
    ['Zurich', 'Zürich', 'district of Zurich']
  ];

  districts['Germany'] = [
    ['Baden-Württemberg'],
    ['Bayern', 'Bavaria'],
    ['Berlin'],
    ['Brandenburg'],
    ['Bremen'],
    ['Hamburg'],
    ['Hessen'],
    ['Mecklenburg-Vorpommern'],
    ['Niedersachsen', 'Lower Saxony'],
    ['Nordrhein-Westfalen'],
    ['Rheinland-Pfalz'],
    ['Saarland'],
    ['Sachsen-Anhalt'],
    ['Sachsen'],
    ['Schleswig-Holstein'],
    ['Thüringen', 'Thüringen']
  ];

  districts['Netherlands'] = [
    ['Drenthe'],
    ['Flevoland'],
    ['Friesland'],
    ['Gelderland'],
    ['Groningen'],
    ['Limburg'],
    ['Noord-Brabant'],
    ['Noord-Holland'],
    ['Overijssel'],
    ['Utrecht'],
    ['Zeeland'],
    ['Zuid-Holland']
  ];

  $.getJSON("api.php?mode=geolookup", function(data) {
    if(data.length != 0) {
      var geocoder = new google.maps.Geocoder;
      data.forEach(function(geocache) {
        var latlng = {lat: geocache.lat, lng: geocache.lon};
          geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === google.maps.GeocoderStatus.OK) {
//            console.log(results);
            if(results[0]) {
              var result = results[0];
//              console.log(result);
              var address = result.formatted_address;
              console.log(geocache.gc + ' address -> ' + address);
              $.ajax({
                url: "api.php?mode=save_geolookup&gc=" + encodeURIComponent(geocache.gc) + "&address=" + encodeURIComponent(address)
              });

              var countryWithDistricts = districts[geocache.country];
              if(countryWithDistricts != undefined) {
                var flag = true;
                result.address_components.forEach(function(entry) {
                  if(flag) {
                    countryWithDistricts.forEach(function(district) {
                      if(district.indexOf(entry.long_name) != -1 && flag) {
                        console.log(geocache.gc + ' district -> ' + district[0]);
                        $.ajax({
                          url: "api.php?mode=save_district&gc=" + encodeURIComponent(geocache.gc) + "&district=" + encodeURIComponent(district[0])
                        });
                        flag = false;
                      }
                    });
                  }
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
    } else {
      console.log('nothing to do, yay! :>');
    }
  });
}

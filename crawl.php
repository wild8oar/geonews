<?
  require_once('util/connection.php');
  require_once('util/logger.php');
?>
<!DOCTYPE html>
<html>
<? require_once('include/head.html'); ?>
  <body>
<? require_once('include/navigation.html'); ?>
    <div class="panel-body">
      <div class='panel panel-info'>
        <div class='panel-heading'>Result of crawl</div>
        <div class='panel-body'>
<?
  ob_implicit_flush(true);

//  resetDb();

  $users = DB::query("SELECT id, username FROM user");
  foreach ($users as $user) {
    gatherAllLogsForUser($user['id'], $user['username']);
  }

  function html($url) {
    $handle = curl_init($url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($handle);
  }

  function doc($html) {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    return $doc;
  }

  function gatherAllLogsForUser($userId, $username) {
    $urlEncodedUsername = urlencode($username);
    $gatheredLinks = gatherLinks("https://www.geocaching.com/seek/nearest.aspx?ul=$urlEncodedUsername&sortdir=desc&sort=lastfound");
    retrieveAllLogs($gatheredLinks, $userId, $username);
  }

  function gatherLinks($url) {
    $html = html($url);
    $doc = doc($html);

    $links = $doc->getElementsByTagName('a');
    $gatheredLinks = array();
    foreach($links as $p) {
      if ($p->hasAttributes()) {
        foreach ($p->attributes as $attr) {
          $name = $attr->nodeName;
          $value = $attr->nodeValue;
          $query = 'http://www.geocaching.com/geocache/';
          if($name == 'href' && substr($value, 0, strlen($query)) == $query) {
            $gc = preg_split('/geocache\//', preg_split('/_/', $value)[0])[1];
            $title = preg_split('/_/', $value)[1];
            $linkValue = "https://www.geocaching.com/seek/cache_details.aspx?wp=$gc&title=$title";
            $gatheredLinks[$gc] = $linkValue;
          }
        }
      }
    }
    return $gatheredLinks;
  }

  function retrieveAllLogs($gatheredLinks, $userId, $username) {
    foreach($gatheredLinks as $gc => $url) {
//      l("parsing $url");
      $html = html($url);
      $images = array();

      $lines = explode(PHP_EOL, $html);
      if (strpos($html, $username)) {
        foreach($lines as $line) {
          if(strpos($line, 'ctl00_ContentBody_uxLegendScale')) {
            $difficulty = retrieveDifficulty($line);
          }

          if(strpos($line, 'ctl00_ContentBody_Localize12')) {
            $terrain = retrieveTerrain($line);
          }

          if(strpos($line, 'ctl00_ContentBody_CacheName')) {
            $cacheName = retrieveCacheName($line);
          }

          if(substr($line, 0, strlen('initalLogs')) == 'initalLogs') {
            $decoded = json_decode(substr(substr($line, 13), 0, -2), true);
            foreach($decoded['data'] as $data) {
              if($data['UserName'] == $username) {
                $created = transformDate($data['Created']);
                $finds = $data['GeocacheFindCount'];
                $log = $data['LogText'];
                $logType = $data['LogType'];

                if(!empty($data['Images'])) {
                  foreach($data['Images'] as $image) {
                    l('<img src="https://img.geocaching.com/cache/log/large/'.$image['FileName'].'" />');
                    array_push($images, 'https://img.geocaching.com/cache/log/large/'.$image['FileName']);
                  }
                }
              }
            }
          }
        }
      } else if(!strpos($html, 'Premium Member Only Cache')) {
        foreach($lines as $line) {
          if(strpos($line, 'ctl00_ContentBody_uxLegendScale')) {
            $difficulty = retrieveDifficulty($line);
          }

          if(strpos($line, 'ctl00_ContentBody_Localize12')) {
            $terrain = retrieveTerrain($line);
          }

          if(strpos($line, 'ctl00_ContentBody_CacheName')) {
            $cacheName = retrieveCacheName($line);
            l("retrieved cache name $cacheName");
          }

          $created = date('Y-m-d');
          $log = 'No log found.';
          $logType = 'Found it';
        }
      } else { // premium
        $lines = explode(PHP_EOL, $html);
        $nextDifficulty = false;
        $nextTerrain = false;
        foreach($lines as $line) {
          if(strpos($line, '<h1 class="heading-3">')) {
            $cacheName = retrieveCacheNameForPremium($line);
          }

          if($nextDifficulty) {
            $difficulty = retrieveDifficultyForPremium($line);
            $nextDifficulty = false;
          }

          if(strpos($line, '<li><span id="ctl00_ContentBody_lblDifficulty" class="span__title">Difficulty</span>')) {
            $nextDifficulty = true;
          }

          if($nextTerrain) {
            $terrain = retrieveTerrainForPremium($line);
            $nextTerrain = false;
          }

          if(strpos($line, '<li><span id="ctl00_ContentBody_lblTerrain" class="span__title">Terrain</span>')) {
            $nextTerrain = true;
          }
        }
        $created = date('Y-m-d');
        $log = 'Premium.';
        $logType = 'Found it';
      }

      $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

      unset($country);
      foreach($lines as $countryLine) {
        if(!isset($country)) {
          foreach($countries as $potentialCountry) {
            if(strpos($countryLine, "created by") && strpos($countryLine, $potentialCountry)) {
              $country = $potentialCountry;
              break;
            }
          }
        }
      }

      $geocacheTypeId = DB::queryFirstField("SELECT id FROM type WHERE type=%s LIMIT 1", getGeocacheType($html));
      l("retrieved type ".$geocacheTypeId);

      if(isset($country)) {
        DB::insertUpdate('geocache', array(
          'gc' => $gc,
          'type' => $geocacheTypeId,
          'name' => $cacheName,
          'difficulty' => $difficulty,
          'terrain' => $terrain,
          'country' => $country,
          'url' => $url
        ));
      } else {
        DB::insertUpdate('geocache', array(
          'gc' => $gc,
          'type' => $geocacheTypeId,
          'name' => $cacheName,
          'difficulty' => $difficulty,
          'terrain' => $terrain,
          'url' => $url
        ));
      }

      l("inserted/updated geocache $gc with name $cacheName, difficulty $difficulty and terrain $terrain");

      $geocacheId = DB::queryFirstField("SELECT id FROM geocache WHERE gc=%s LIMIT 1", $gc);
      $logTypeId = DB::queryFirstField("SELECT id FROM logtype WHERE type=%s LIMIT 1", $logType);
      $logId = DB::queryFirstField("SELECT id FROM log WHERE geocache=%i AND user=%i LIMIT 1", $geocacheId, $userId);

      if(isset($logId)) {
        $logIdWithDate = DB::queryFirstField("SELECT id FROM log WHERE geocache=%i AND created=%s LIMIT 1", $geocacheId, $created);
        if(isset($logIdWithDate) && $log != 'No log found.' && $log != 'Premium.') {
          DB::query("UPDATE log SET log=%s WHERE id=%i", $log, $logIdWithDate);
          l("updated log for geocache $gc and user $username");
          DB::query("DELETE FROM image WHERE log=%i", $logIdWithDate);
          foreach($images as $image) {
            DB::insert('image', array(
              'log' => $logIdWithDate,
              'url' => $image
            ));
          }
          l("inserted/updated images for geocache $gc and user $username");
        } else {
          l("did not update premium log for geocache $gc and user $username");
        }
      } else {
        DB::insert('log', array(
          'user' => $userId,
          'geocache' => $geocacheId,
          'created' => $created,
          'type' => $logTypeId,
          'log' => $log
        ));
        l("inserted log for geocache $gc and user $username");
        $logIdWithDate = DB::queryFirstField("SELECT id FROM log WHERE geocache=%i AND created=%s AND user=%i LIMIT 1", $geocacheId, $created, $userId);
        foreach($images as $image) {
          DB::insert('image', array(
            'log' => $logIdWithDate,
            'url' => $image
          ));
        }
        l("inserted/updated images for geocache $gc and user $username");
      }

      if(isset($finds)) {
        DB::update('user', array(
          'finds' => $finds
        ), "username=%s", $username);
        l("$username found geocache <a href='$url'>$gc</a>.");
      }
    }
  }

  function getGeocacheType($html) {
    if(strpos($html, 'title="Multi-cache"')) {
      return 'Multi-cache';
    } else if(strpos($html, 'title="Mystery Cache"') || strpos($html, 'Mystery')) {
      return 'Unknown Cache';
    } else if(strpos($html, 'title="Traditional Geocache"') || strpos($html, 'Traditional')) {
      return 'Traditional Cache';
    } else if(strpos($html, 'title="Wherigo Cache"')) {
      return 'Wherigo Cache';
    } else if(strpos($html, 'title="EarthCache"')) {
      return 'Earthcache';
    } else if(strpos($html, 'title="Virtual Cache"')) {
      return 'Virtual Cache';
    } else if(strpos($html, 'title="Letterbox Hybrid"')) {
      return 'Letterbox Hybrid';
    }
    return 'unknown';
  }

  function retrieveDifficulty($line) {
    $difficulty = preg_split('/.gif/', preg_split('/.*\/stars\/stars/', $line)[1])[0];
    return (double)str_replace('_', '.', $difficulty);
  }

  function retrieveDifficultyForPremium($line) {
    $difficulty = preg_split('/</', preg_split('/>/', $line)[1])[0];
    return (double)str_replace('_', '.', $difficulty);
  }

  function retrieveTerrain($line) {
    $terrain = preg_split('/.gif/', preg_split('/.*\/stars\/stars/', $line)[1])[0];
    return (double)str_replace('_', '.', $terrain);
  }

  function retrieveTerrainForPremium($line) {
    $terrain = preg_split('/</', preg_split('/>/', $line)[1])[0];
    return (double)str_replace('_', '.', $terrain);
  }

  function retrieveCacheName($line) {
    return trim(preg_split('/</', preg_split('/>/', $line)[1])[0]);
  }

  function retrieveCacheNameForPremium($line) {
    return trim(preg_split('/</', preg_split('/>/', $line)[1])[0]);
  }

  function transformDate($date) {
    return substr($date, 6, 4).'-'.substr($date, 0, 2).'-'.substr($date, 3, 2);
  }
?>
        </div>
      </div>
    </div>
  </body>
</html>

<?
  require_once('general.php');
  require_once('connection.php');
  require_once('logger.php');
  ob_implicit_flush(true);
?>
<!DOCTYPE html>
<html>
<?
  require_once('components/head.html');
  printBodyTag();
  showNavigation();
?>
    <div class="panel-body">
      <div class='panel panel-info'>
        <div class='panel-heading'>Result of crawl</div>
        <div class='panel-body'>
<?
  $cookie = tempnam('tmp','cookie');

  $handle = curl_init('https://www.geocaching.com/login/default.aspx?RESETCOMPLETE=y&redir=%2fplay');
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_COOKIEJAR, $cookie);
  curl_setopt($handle, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36');
  curl_setopt($handle, CURLOPT_POSTFIELDS, "__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=2fwrxDHWjbIY%2FbX9pSVQnhv0ffDl8nER4UaUy2CoixAtC96fajuMn12H4r0un3v4pHi2O9mC7LEhDSQC9shyx5MYomDGXVpKRrRwJjtacr9Cn8nRMfxcEiut7vVeO6d2I3VN1k0kTDk9cAjaieZ2MoPwmFd28VIVTuwiaT0zUwoYAC2IbuCIL%2FRqGkdHIitqKrYPCXuRIjfbQgwFe2ow7OWM8KTCEiiS5lYxaZbotJOmTAGSk0wZJOYr4ABXzn8hXs0eP7atu136erL%2FFrsU5qVM6RMHzPxagyzEhLpneHT3F4fmlJUSmfTJQTfg560KvRysRqHCUnWVYoVQco9wNpoRUDFGSA6FZX68U2gmCxeDdP5VaFAyWpFT1nJcjHy1VwzQOHZ4cnGb8vam2XAyHeqDPlDLef8CVgRi2Y92U4s9MjOHwEZx%2BccRRmbcsJKrDuLXl57ZkpWrwO7STIQwwRM9x1pgyCvFv4%2FEsfsaOo8W00XS7zkK17XY3qlNdeLQC4IxLkyDIEqHKYuQRXXO4pdI4ZT8jlT%2BHW%2BOJf%2BiNF%2BJjlc%2FP%2BsTnjDXBR6rYeRxHqXfI13gc%2Br%2BNB%2BZcEuug9oMU%2BvoxnbSOP1O56u5fI6Wc6kDo%2Bm30u87UTCmTzSA%2BjeSzg2hxPjRWvHYkzNef%2BT5rAqfWE%2BPUKxrFtsrPHzHPRXc5t2piFC80I9WWssfevw7sdi0N5X8Xp2qzeLTbgHdcC9w%2Bl9TjdsHI8%2BlQqDf8QtJLb9AtpIG6jfTyOpOnv%2FvnAhAWemH%2FLk4I%2FmuTIotLfjosJjKrCvRtE1vimbC43FujC349aYaMhkgD1KXxbT%2BRIYVSojqaAYp1BMbfhHZh6u310EC5%2BH8ps99SXp0v3RX2mEXlyoqVK6xDc0h5CRlTnzltm9%2BvxgQ6OwEAwoErp9pO5G%2B0Wg%2B6KpjwA95KbU5%2BfVgTYxGzFGwSzwyT2YVWKSHOcTd44KI44HK%2BFjQwpBHovB5LKjU8Z0BHbaUUchXPmn6%2F69kh%2B6wJv6AfSW1VPvVPROX2yLLW7pUj3Z9SChK2rfxB295f6pJgYSGKYWVJKzk4DHLOmOOuFxvVfCyn7%2FC59Yar8eJv0cg6pkkDcjOFMgKVkp506AGbYq0yu6Ixo15QGtiKSVAIZxeBrKpC4Td1KJzmSUGB%2FyjxcrupxDzsgfL9JtgLckTTj2il4DeJuBLbUS1bdjTWKNz2kw%2Fq8IndIkOu5LFZJKEo2qE8IpHG7cQZ6OM7VAR5aKdNWQQFCHRT0OB7M9th3NAi1B88OGtujS8TkKoHwL19bwgVPyLq1nElyO0CCIt4uBbKp0Ej9c6mScdv358jZDo6rS399HpCg7nmyuf79eSpyrcEclDfqiuSHVJsmVypAH%2FvZQQd2fu8bkl%2Fivx9PeFHiZozgeHIXU99rYGAAJe4ONKQM15assFTdh2vTPw%2FKganBcga7p24hJdE2Yspkaavc2ykzNn8pgxbJZoesQbb9t0zgh1yAwA7xLkLroabOTUUQqQHqixwotC6Cc7%2B1cx4zrlZspUGeKS3Wgl4pkjX7XY1%2Fw93kTcnkzt2ywjuBCHf%2BjjNNdtxrZ5gRZQJqEv29eOuprGWhhPqEyOgeNB2q0RF3ba7kP5Kny0nfFr5Pci6STAgaOPYrpbHbO2ufVgKKLixt7%2F2ljGd8q6WVKUtcXzS1K5VQqC86LhZIyiQQXhfBVH9%2BxHsGxrsf11eguggLWnG332EKjSPVwhGJnWnYa%2FJiekyPciJ0m2S2KiR2DL1d%2BplJdXX%2BCjLOKPdhBCiMq90yg5wEq4RLRHFmI%2Fo1Hrm1C9PvWo4PoWYkCJDF5lvdvVyXL4ST1xHZnaCaUWtWPDanRWil5v7DYRX8tt%2Fs6deECc7hxEGHu7KHUxL9U6GEGnesooT4TMJ5kuYN6qvZ%2BVrnj2OxuiELoxOJWf7nYHOI79jXvWLqTYUAijUmTaVuFCVIx1w8UEFlcTW3CqbSHJv0Wv6qoktvPSK5YRnL1f1itNs5MMu3Q9pVtQjU0yN5YYcu4yMtsoLmPOc8sYZTWXBXdkBmk%2BbNaqnc4AhvKzh6AO8%2BCwXKqQa16nIJv%2FXo%2FA4YsCIUoma9WPoinNZkwz9rMwOA8Vq4BPpzAmt2MZZhLcPBn0KhxhbaX5guNJUP2KNzIXgCzd9kXBXDlgbaN88WRlryLIVjvUI8jJlCt3GM%2BDzSyhjRiq8vlChxcMisF9SgYEOgmGGPNugLVvqC%2F%2Bw6Yy63aDJebGf2H1fDeuUGMfVIiWBNzvY3lgBC2dP1wjGfpUh%2B0Dzxy4o7VO9%2BTQ6tY%2B1IMueVxwJKVvHPO7%2FXjL1xwKHQUB9NAUubP94VDJZs67HrQHlS1hx6qpba%2B7%2FV7zj7zV3LD9JK%2BLFFlz8s4fjvrLDuxOpB6mbvlRZQCZ99Ivr5ZT1I2XupWSNUhd8pshyBv8m2OOPeBd0OmbtDB85Kehraji%2BPYQrGS0828j%2BbgToeuu7oNC263IwSSV5p46BXPhe7R8XnRTRDFXq97j3A7ksu2j5u0CkZEnm9QL22g8ElVJIxM5oiMQfYZ5jBQainkAf7yyvWxNucB8LnDQCfuM7HscpAeVMYKXeAT2POSVq%2BFFmLamszFX18WGGeJgSLfV3wrVFLyJfue3yo4iqgwCGYj6SHmhgd3YewXH2godXDMdxkT%2BY6lu3t7pJMJAA%2BB4OojdsxeKacM8KxdVVXY6o%2FPhXCf2t5hQPyODHxffvntZSaQYrFkg%2BftRVuG0UDaqclF8JhXANC%2F0wPXTfLYmT%2FMNXSZuJUA8OznWvjCrzqoLWlLjJ%2Ff5MmoamLk%2B7OCeJQv%2Bp%2BJcAdchJ2e20aXogjfweS%2F9kXXU4xr9qUQsCddFc9OOn3IV%2B6vukOi7csJE%2FTqOXFGZ1l057LHa4yIVZ3IsQ0rXyPapeblG%2BfLy6zq6JO3OkXP4Rc9XVEW7lUyUK%2B5%2FSigpJVBgWoEdkhAI8Z8IYePZB3mckYNNG7mIbFOxDIa7XtKT1PRleoOzOAJkqwOzNlhUcIP7DZ6%2BxtHAy7WKMEZNxMVAnRwV2WyFUEgcgc4U9CTsT6mWwUVs%2B64TkyqLuMKHCcY73zjzAlY1ucx0UCwMrH6SyvrjtgRpCqqTZmrFE058TIAPz2Dwni%2FsBcpZZe3MOWBJoSpJSeeeZk0qaRby79CLj9vS6QfRrTUJhP5Z5C2Hp1VMplN5QXs0ILOcKxdhIPZCFKZOSgYc2xC874MAbqVEC%2BGMGbOVJEIKGW%2BClYMU9vWy85OkcrZ6cV8uAXDJYiD47IgDxl%2B%2Bb1XMmi0G7G1MlgH8IBpxJtWPlqWlC039ErzR5zHxH8t2W4tSFrd%2BrKIWQQR7EVT%2FnJwRAlDZW%2FkFZB2ovcLsotsrgJLxYWwHufNd7mBHMBGz0R0ftze1hm9%2F5c0%3D&__VIEWSTATEGENERATOR=25748CED&ctl00%24ContentBody%24tbUsername=$GC_USER&ctl00%24ContentBody%24tbPassword=$GC_PASSWORD&ctl00%24ContentBody%24cbRememberMe=on&ctl00%24ContentBody%24btnSignIn=Sign+In&_a=_b");
  $html = curl_exec($handle);

  foreach (DB::query("SELECT id, username FROM user") as $user) {
    $username = $user['username'];
    $userId = $user['id'];
    $urlEncodedUsername = urlencode($username);

    $handle = curl_init("https://www.geocaching.com/seek/nearest.aspx?ul=$urlEncodedUsername&sortdir=desc&sort=lastfound");
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_COOKIEFILE, $cookie);
    curl_setopt($handle, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36');
    $html = curl_exec($handle);

    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->loadHTML($html);

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
            if(strpos($value, '_')) {
              $title = preg_split('/_/', $value)[1];
            } else {
              $title = $value;
            }
            $linkValue = "https://www.geocaching.com/seek/cache_details.aspx?wp=$gc&title=$title";
            $gatheredLinks[$gc] = $linkValue;
          }
        }
      }
    }

    $gatheredLinks = array_reverse($gatheredLinks);

    $avatarFound = false;

    foreach($gatheredLinks as $gc => $url) {
      l("$url");

      if(!$avatarFound) {
        // avatar
        unset($accountUrl);

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_COOKIEFILE, $cookie);
        curl_setopt($handle, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36');
        $html = curl_exec($handle);

        $lines = explode(PHP_EOL, $html);
        if (strpos($html, $username)) {
          foreach($lines as $line) {
            if(substr($line, 0, strlen('initalLogs')) == 'initalLogs') {
              $decoded = json_decode(substr(substr($line, 13), 0, -2), true);
              //var_dump($decoded);
              foreach($decoded['data'] as $data) {
                if($data['UserName'] == $username) {
                  $accountUrl = 'https://www.geocaching.com/profile/?guid='.$data['AccountGuid'];
                  l("found account guid: ".$data['AccountGuid']);
                  $avatarFound = true;
                }
              }
            }
          }
        }

        if(isset($accountUrl) && $accountUrl != '') {
          $handle = curl_init($accountUrl);
          curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($handle, CURLOPT_COOKIEFILE, $cookie);
          curl_setopt($handle, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36');
          $html = curl_exec($handle);
          $lines = explode(PHP_EOL, $html);
          foreach($lines as $line) {
            if(strpos($line, 'ctl00_ContentBody_ProfilePanel1_uxProfilePhoto')) {
              $avatarUrl = preg_split('/\.jpg/', preg_split('/http:\/\/img.geocaching.com\/user\/avatar\//', $line)[1])[0];
              $avatarUrl = "https://img.geocaching.com/user/avatar/".$avatarUrl.".jpg";
              $avatarUrl = httpsifyUrl($avatarUrl);
              l($avatarUrl);
              DB::update('user', array(
                'avatar' => $avatarUrl
              ), "username=%s", $username);
            }
          }
        }
      }

      // gps
      $handle = curl_init($url);
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($handle, CURLOPT_COOKIEFILE, $cookie);
      curl_setopt($handle, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36');
      $page = curl_exec($handle);
      $lines = explode(PHP_EOL, $page);
      unset($gps);
      unset($lat);
      unset($lon);
      unset($country);
      unset($finds);
      unset($fp);
      if(strpos($page, "ctl00_ContentBody_MapLinks_MapLinks")) {
        foreach($lines as $line) {
          if(strpos($line, "ctl00_ContentBody_MapLinks_MapLinks")) {
            $gps = $line;
            break;
          }
        }
      }

      if(isset($gps) && $gps != '') {
        $latLon = preg_split('/" target="\_blank">Geocaching.com Map/', preg_split('/default.aspx\?/', $line)[1])[0];
        $lat = preg_split('/&/', preg_split('/lat=/', $latLon)[1])[0];
        $lon = preg_split('/lng=/', $latLon)[1];
        l("found gps: $lat $lon");
      } else {
        l("found no gps");
      }

      $handle = curl_init($url);
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($handle, CURLOPT_COOKIEFILE, $cookie);
      curl_setopt($handle, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36');
      $html = curl_exec($handle);

      $images = array();

      $lines = explode(PHP_EOL, $html);
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
          //var_dump($decoded);
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
              break;
            }
          }
        }
      }
      if(!isset($log)) {
        continue;
      }

      $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

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

      $nextFpLine = false;
      if(!isset($fp)) {
        foreach($lines as $favoritePointLine) {
          if($nextFpLine) {
            $fp = trim($favoritePointLine);
            break;
          }
          if(strpos($favoritePointLine, "<span class=\"favorite-value\">")) {
            $nextFpLine = true;
          }
        }
      }
      if(!isset($fp)) {
        $fp = 0;
      }

      $geocacheTypeId = DB::queryFirstField("SELECT id FROM type WHERE type=%s LIMIT 1", getGeocacheType($html));
      l("retrieved type ".$geocacheTypeId);

      if(isset($country)) {
        if(isset($lat) && isset($lon)) {
          DB::insertUpdate('geocache', array(
            'gc' => $gc,
            'type' => $geocacheTypeId,
            'name' => $cacheName,
            'difficulty' => $difficulty,
            'terrain' => $terrain,
            'favorites' => $fp,
            'country' => $country,
            'lat' => $lat,
            'lon' => $lon,
            'url' => $url
          ));
        } else {
          DB::insertUpdate('geocache', array(
            'gc' => $gc,
            'type' => $geocacheTypeId,
            'name' => $cacheName,
            'difficulty' => $difficulty,
            'terrain' => $terrain,
            'favorites' => $fp,
            'country' => $country,
            'url' => $url
          ));
        }
      } else {
        DB::insertUpdate('geocache', array(
          'gc' => $gc,
          'type' => $geocacheTypeId,
          'name' => $cacheName,
          'difficulty' => $difficulty,
          'terrain' => $terrain,
          'favorites' => $fp,
          'url' => $url
        ));
      }

      l("inserted/updated geocache $gc with name $cacheName, difficulty $difficulty and terrain $terrain and fp $fp.");

      $geocacheId = DB::queryFirstField("SELECT id FROM geocache WHERE gc=%s LIMIT 1", $gc);
      $logTypeId = DB::queryFirstField("SELECT id FROM logtype WHERE type=%s LIMIT 1", $logType);
      $logId = DB::queryFirstField("SELECT id FROM log WHERE geocache=%i AND user=%i LIMIT 1", $geocacheId, $userId);

      if(isset($logId)) {
        $logIdWithDate = DB::queryFirstField("SELECT id
                                              FROM log
                                              WHERE
                                                geocache = %i AND
                                                user = %i AND
                                                year(created) = year(%s) AND
                                                month(created) = month(%s) AND
                                                day(created) = day(%s)
                                              LIMIT 1", $geocacheId, $userId, $created, $created, $created);

        if(isset($logIdWithDate)) {
          DB::query("UPDATE log SET log=%s WHERE id=%i", $log, $logIdWithDate);
          l("updated log for geocache $gc and user $username");
          DB::query("DELETE FROM image WHERE log=%i", $logIdWithDate);
          foreach($images as $image) {
            $image = httpsifyUrl($image);
            DB::insert('image', array(
              'log' => $logIdWithDate,
              'url' => $image
            ));
          }
          l("inserted/updated images for geocache $gc and user $username");
        } else {
          l("did not update log for geocache $gc and user $username");
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
        $logIdWithDate = DB::queryFirstField("SELECT id
                                              FROM log
                                              WHERE
                                                geocache = %i AND
                                                user = %i AND
                                                year(created) = year(%s) AND
                                                month(created) = month(%s) AND
                                                day(created) = day(%s)
                                              LIMIT 1", $geocacheId, $userId, $created, $created, $created);
        l("found log id with date: $logIdWithDate for saving the images");
        foreach($images as $image) {
          $image = httpsifyUrl($image);
          DB::insert('image', array(
            'log' => $logIdWithDate,
            'url' => $image
          ));
          l("inserted image for geocache $gc and user $username");
        }
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
    } else if(strpos($html, 'title="Wherigo Cache"')) {
      return 'Wherigo Cache';
    } else if(strpos($html, 'title="EarthCache"')) {
      return 'Earthcache';
    } else if(strpos($html, 'title="Virtual Cache"')) {
      return 'Virtual Cache';
    } else if(strpos($html, 'title="Letterbox Hybrid"')) {
      return 'Letterbox Hybrid';
    } else if(strpos($html, 'title="Webcam Cache"')) {
      return 'Webcam Cache';
    } else if(strpos($html, 'title="Event Cache"') || strpos($html, 'title="Mega-Event Cache"') || strpos($html, 'title="Giga-Event Cache"')) {
      return 'Event Cache';
    } else if(strpos($html, 'title="Mystery Cache"')) {
      return 'Unknown Cache';
    } else if(strpos($html, 'title="Traditional Geocache"')) {
      return 'Traditional Cache';
    }
    return 'unknown';
  }

  function retrieveDifficulty($line) {
    $difficulty = preg_split('/.gif/', preg_split('/.*\/stars\/stars/', $line)[1])[0];
    return (double)str_replace('_', '.', $difficulty);
  }

  function retrieveTerrain($line) {
    $terrain = preg_split('/.gif/', preg_split('/.*\/stars\/stars/', $line)[1])[0];
    return (double)str_replace('_', '.', $terrain);
  }

  function retrieveCacheName($line) {
    return trim(preg_split('/</', preg_split('/>/', $line)[1])[0]);
  }

  function httpsifyUrl($url) {
    $imageUrlHandle = curl_init($url);
    curl_setopt($imageUrlHandle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($imageUrlHandle, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($imageUrlHandle, CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.111 Safari/537.36');
    curl_exec($imageUrlHandle);
    $redirectUrl = curl_getinfo($imageUrlHandle)['redirect_url'];
    $redirectUrl = preg_replace("/^http:/i", "https:", $redirectUrl);
    return $redirectUrl;
  }

  function transformDate($date) {
/*
    // not premium user
    $parts = explode('/', $date);
    $month = $parts[0];
    $day = $parts[1];
    $year = $parts[2];
    return "$year-$month-$day"."T".date('G:i:s')."Z";
*/
    $parts = explode(' ', $date);
    $day = $parts[0];
    $month = date_parse($parts[1])['month'];
    $year = $parts[2];
    return "$year-$month-$day"."T".date('G:i:s')."Z";
  }
?>
        </div>
      </div>
    </div>
  </body>
</html>

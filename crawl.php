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
  curl_setopt($handle, CURLOPT_POSTFIELDS, "__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=zBL0KC%2FuHhlZAVhAYNvkIOJxI1WmxzdBcRztj85NfHI%2FemS6hMbi4Pm70ciJ0Oa%2BZuFSJb823UnT%2F%2F7BpMIp%2FLkbWyo7yuY%2BWGUVEDQsO3ZOFiWPgN6sH%2BSnDCi8USIZ5zw0NYR%2Bm5DurcT%2FGqpkehiao%2BEZ3xh0R1c%2B3zdH3EzEx9HsWXXT%2FuL4PotGi6qMHzM1PIJWsUFTupk234a9B9zGMK7HqvSA4TxmTqYohGhn90URSJOGzvk2xkIOGqwFeiQ56UAjb2gddR4bHpGWUc8gg6CyD5SWxJ0z%2FUZ0Ua3un55FRGXzFlmFk6NLAsPgZQGPzMt3BYDbIdx32H3aPH7844fByvPLf9HueN5psWOltOmSj0af3dQEfsIXYgxBYQq5p6Hxu%2BOb%2F1tbZbwmbTn3EZ6LkKIU7OSPJR9qzOSsVrHMLQXYfyOMCyVdeADr8Tr%2BS02OQhHxoB%2BxAQGEVZJ9A98yFmc4evvJNlLMp2qAq%2FwYzYTOCtTjwOqqUsN4l4tfLE2La3MnjTGx217LknVol0Z6Qlb8ITuzpgxDWt%2BmlA640gYCuYD2DfFC2zbe768dj%2Bn1eUdOekB%2FyK%2F7FEwXFvcoMngpaffzQvqp5t7O4HM5MrZEbAUT91xPB%2BoQOdwUzJENFETzBFQB9DbXfQSBW%2FsxX0pJDzv%2FRruOZ3y%2BN5qCHKEAhpLPHm3aCzD2Vpr0Gs3rTdws58UcxOnKwQoRJ9JwbeBLuVQf%2BL%2FnNELzeqjvh0vw9KX9YgrNxAPKZUiVyzjB1ksPrWBPOBMP3l5C22l%2FtXCGwkoWndff%2Fi%2BfBHcxTbagXpPA1fScPriXaiuBcynDKGZOIsc4PIaedts6t1%2BZ%2Bbm59fBhis9IywLTguKp%2FWQBTVTeEMN7qmtkkwYeWNVDLAjJY8uE3RgdackM2Vt3qBYXg0pBxDxuayWzjR0Zo%2BDriXSSwKKjzP0ewaXtC%2Fx22gtU%2FdKcmzc7n8TRYB83VclnAd44eRJ10qbPtybz7h%2BoNh1oo09rw8P98ierWaOOJthX1SbFqhX9hskS8X61NuONecI%2B2mSgEcsr1YMYRP2g9s0TIbaTVjp8TMQzyugkTElLbImWmtu5P3FSz72RORHAFBag1BrRMy04dwZcyQtiKKXj8LFaMzzhOQaRNQUFPt2xaQJrdjCwGojdPH1nvfwgcvmsXr1wA9jAN6bIp%2FI2aQ9KN4MItC8QRbYL9XTzBkeUmrYmeghApGala9XuiwpW4gUsq4pxUMBiq3rjwkaEnj7ZBmKNVF%2BYYN4hiUcAq9mQcHbVyhw2IhDbuT%2FsqVgyJL6amYAWaWx9nWRl9zQk%2BPU2xFKLVMS8F9vD4%2BCfSV%2BpVup4xIHTrCYNIVTnnkgMiZo5nCDWKxjtrKVhk6%2F52DlSRfBIx6eHa%2FjZTrHA62aXjq5AOyWtXBMpGQ%2Fy0nIhYFuOh86weW1ZcZVM8E%2BrzhlyzewNGZJFROFO9YCjxAEwnaApirl4GZ1hR7rn41nEG0YEoWPLbHKaRva8TnqioAgjAi2iARb%2BjDOwZkPkVk%2BWeYPlYNCxctud7vlWHr9HDQpz%2BvWoSB4Eq5eC46NQ2m3ofckm4lKW1w1EuauhPEJJHASzIgY1ebLS5BM41EPXQ19FyOmwwUtpetVjKcGr3SzsBhxh0UNXskEKNQe%2FppFtTxFBUTDOeLSIpusFw0RxZWYjf0o3OSSCDLWsAFTZvZcDylz4UAWaxY%2Bmq71rtHSFzeKvYdUOkZIFMxNAviN4PDjWqjEAKOjHdohSH1kv6iTU7DU7%2FQ0p%2B%2FUW3w%2Fy7Xv64agR8j4tdbG3I%2FuH%2FTo9y5mzIDDYB1jHEjNtLd6msipAgX847YQ74NSJlkADITfVv3p8toVzUEJp%2F8HwKbf8U5uZ9Zn2UAcWXtC%2BAiqKlJss%2Fhj1NcrjzK3JNk36LtWN1fyZB4BXvelhXlSvky5tzWNLNJYcoRNO3kpvEAapG4vPUlrQoj%2FiLUgZ8MyNPWQhdm2UjCe9oOPk31XhHkcoH2G9Ee%2BDNx0oOm7IT%2BfvMfbYlMBxICNDKoF9KNGQLjD321Iv51akHQIQZkuktPInt%2B51lurBV%2FALDUMplXKt8VKVlgmpJjUYIwBRrsvmSbKsjHdPrQk4KY9%2F51SgCWNfEAJ1K9jFBsQh2TXPkcdqEy1w7IJBTGVTEsRaMAc06sfFslb7iOuGQHqnGGVK1VwQvVl8zLmntYnTgpMuYoT944JVV%2BxvUUWbqrKYJujaZEbvwtnyKdcL9I9irdKNWz8CBJna9XO43P67%2Bqt4EK8rgj3pK1VWa8u1QQoHYKP1hEqWaGgsYUzbQX9xdrvitw%2Bs5ZGm0natk2FC6TWJpqhu%2FgksQsMtV6SITDEofdl6uMinNklVR8c9A1EEF%2FHt9ozr5Ji9REwaq4Gj1yr3DN0KM2tDvn1ox%2FMpc%2BXT40th8R8TXGeVRhoN7GWKrmX1zmyIJsUvjIe8mEAGWo4WbU1ysg9LB9Cx0nIs2OHFjiA5JIjCk9OxyJLCXuIITXScXthNW6oh2B85lwI1MCDiVq%2BziNT3A%2FXT2uUoOyOHXx0Fl6HkLEJGK0RMdYQXiJM7MJMcHS30gCM%2BqCRGF7d2vl8sGLzRgyXNDKd19mZgSPjGharrOBwwhAk%2BhPXAGWlHj0koGpAWQAigREkhyB6AaIoPirqzznNFRRhYzrq3GIbtCWutDS95pfdLyqWe3vCUugjKs3HZrv%2FtcqSXe62FYTdUJ8dgvry%2BnBr1ioGqErgCRuWIb%2FvP2zgJ%2BuhLO8%2BvGbeEV7YJ%2ByXR5r7%2FUitFK4W4pQCjc5%2F9QKJuOZNEmi3QQ77femp4yq04WtVHfBnI574OjTig%2BK2p6Se2rqWTZQ1nILoF1HCjgkXeV2zxn7usLXTtXMkXVbLiRBPmSXHPOqRMMJkTA2NQONWWB66wBwSaRvst0kmxPnXSKOB%2BT84PnSy4wFikCUm%2FmL3eWoQZbMuq8wx%2BjEpi%2BD1Y%2B9DsYe5EEsYHubq8JWAQxxsbgs7rKqeoPeDRieAkZ%2FWIdmTfLHicEfdw1Guqb3cnGH0wUfZRhGQ%2Fafrsvrc7c3eM1R8d3agF0n%2FFzFsu0qZzHcZhE2ZhGqpJm%2BFb8dcOppSHnE7bmEms4nsouQE0X0ixEb5hA9eWa2WXj3WiP22ciT6nz2ygCeVQL6uj%2B3FyyKWDCR%2BkgvR0Xj84M%2BMsC2BoNfpNmJjf%2BefJJuHPsJuLBNEEZVvhRiSOO%2FwcD7bGhalBhT5V9e1QNjliWRsFjqT9Rw%3D%3D&__VIEWSTATEGENERATOR=25748CED&ctl00%24ContentBody%24tbUsername=$GC_USER&ctl00%24ContentBody%24tbPassword=$GC_PASSWORD&ctl00%24ContentBody%24btnSignIn=Sign+In");
  curl_exec($handle);

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
            $title = preg_split('/_/', $value)[1];
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
//      l($html);
      if (strpos($html, $username)) {
        l("normal");
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
      } else if(!strpos($html, 'Premium Member Only Cache')) {
        l("old one");
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

          $created = date('Y-m-d')."T".date('G:i:s')."Z";
          $log = 'No log found.';
          $logType = 'Found it';
        }
      } else { // premium
        l("premium");
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
        $created = date('Y-m-d')."T".date('G:i:s')."Z";
        $log = 'Premium.';
        $logType = 'Found it';
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
          'url' => $url
        ));
      }

      l("inserted/updated geocache $gc with name $cacheName, difficulty $difficulty and terrain $terrain");

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
        if(isset($logIdWithDate) && $log != 'No log found.' && $log != 'Premium.') {
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
    if(strpos($html, 'title="Multi-cache"') || strpos($html, 'Multi-cache')) {
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
    } else if(strpos($html, 'title="Mystery Cache"') || strpos($html, 'Mystery')) {
      return 'Unknown Cache';
    } else if(strpos($html, 'title="Traditional Geocache"') || strpos($html, 'Traditional')) {
      return 'Traditional Cache';
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

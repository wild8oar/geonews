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
        $next = false;
        $cacheName = '';
        foreach($lines as $line) {
          if($next) {
            $cacheName = trim($line);
          }
          $next = checkIfNextLine($line);

          if(strpos($line, '<img src="/images/stars')) {
            $difficulty = retrieveDifficultyForPremium($line);
          }

          if(strpos($line, '<img src="/images/stars')) {
            $terrain = retrieveTerrain($line);
          }
        }
        $created = date('Y-m-d');
        $log = 'No log found.';
        $logType = 'Found it';
      }

      $geocacheTypeId = DB::queryFirstField("SELECT id FROM type WHERE type=%s LIMIT 1", getGeocacheType($html));
      l("retrieved type ".$geocacheTypeId);

      DB::insertUpdate('geocache', array(
        'gc' => $gc,
        'type' => $geocacheTypeId,
        'name' => $cacheName,
        'difficulty' => $difficulty,
        'terrain' => $terrain,
        'url' => $url
      ));
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
    } else if(strpos($html, 'title="Mystery Cache"')) {
      return 'Unknown Cache';
    } else if(strpos($html, 'title="Traditional Geocache"')) {
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

  function checkIfNextLine($line) {
    return strpos($line, 'ctl00_ContentBody_uxWptTypeImage');
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

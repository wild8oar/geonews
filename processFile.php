<?
  require_once('util/connection.php');
  require_once('util/logger.php');
  ob_implicit_flush(true);

//  resetDb();

  $feed = simplexml_load_file('pocketquery.gpx');
//  echo "<div class='alert alert-info' role='alert'>";
  $username = '';
  $finds = 0;
  $inserted = 0;
  foreach ($feed->wpt as $wpt) {
    $cache = $wpt->children("http://www.groundspeak.com/cache/1/0/1")->cache;
    if($cache == '') {
      $cache = $wpt->children("http://www.groundspeak.com/cache/1/0")->cache;
    }
    $lat = (double)$wpt['lat'];
    $lon = (double)$wpt['lon'];
    $type = (string)$cache->type;
    $typeId = DB::queryFirstField("SELECT id FROM type WHERE type=%s LIMIT 1", $type);
    $difficulty = (int)$cache->difficulty;
    $terrain = (int)$cache->terrain;
    $url = (string)$wpt->url;
//    l("url $url");
//    l($cache->logs);

    foreach ($cache->logs->log as $log) {
      $gc = (string)$wpt->name;
      $name = (string)$cache->name;
      $username = (string)$log->finder;
      $logtext = (string)$log->text;
      $logType = (string)$log->type;
      $logDate = (string)$log->date;
//      l("gc $gc");

      if($inserted == 0) {
//        l("username $username");
        DB::insertIgnore('user', array(
          'username' => $username
        ));
//        l("inserted user $username");
        $inserted = 1;

        $userId = DB::queryFirstField("SELECT id FROM user WHERE username=%s LIMIT 1", $username);
        $logIds = DB::queryFirstColumn("SELECT log.id FROM image, log WHERE image.log = log.id AND log.user = %i", $userId);
        foreach($logIds as $logId) {
          DB::delete('image', "log=%i", $logId);
//          l("deleted image");
        }
        DB::delete('log', "user=%i", $userId);
      }

      DB::insertUpdate('geocache', array(
        'gc' => $gc,
        'name' => $name,
        'type' => $typeId,
        'lat' => $lat,
        'lon' => $lon,
        'difficulty' => $difficulty,
        'terrain' => $terrain,
        'url' => $url
      ));
//      l("inserted geocache $gc");

      $geocacheId = DB::queryFirstField("SELECT id FROM geocache WHERE gc = %s LIMIT 1", $gc);
      $logTypeId = DB::queryFirstField("SELECT id FROM logtype WHERE type = %s LIMIT 1", $logType);
//      l("logType $logType");
//      l("logTypeId $logTypeId");
//      l("retrieved geocache id $geocacheId for name $name");

      DB::insert('log', array(
        'user' => $userId,
        'geocache' => $geocacheId,
        'created' => $logDate,
        'type' => $logTypeId,
        'log' => $logtext
      ));
//      l("inserted log for geocache $gc and user $username");
    }
    $finds++;
  }
  DB::update('user', array(
    'finds' => $finds
  ), "username=%s", $username);

//  echo "</div>";
  unlink(realpath(dirname(__FILE__))."/pocketquery.gpx");
  Header('Location: map.php');
?>

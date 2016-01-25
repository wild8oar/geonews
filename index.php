<?
  require_once('general.php');
  require_once('connection.php');
  require_once('logger.php');
  require_once('checkLogin.php');
?>
<!DOCTYPE html>
<html>
<?
  require_once('components/head.html');
  printBodyTag();
  showNavigation();
?>
   <div class="panel-body">
<?
  $results = DB::query("SELECT
                          geocache.name,
                          geocache.gc,
                          geocache.difficulty,
                          geocache.terrain,
                          geocache.country,
                          geocache.url,
                          geocache.address,
                          geocache.lat,
                          geocache.lon,
                          geocache.district,
                          type.type AS 'type.type',
                          log.created,
                          logtype.type,
                          log.log,
                          log.id AS 'log.id',
                          user.username,
                          user.id AS 'user.id'
                        FROM
                          geocache, log, logtype, user, type
                        WHERE
                          geocache.id = log.geocache AND
                          log.user = user.id AND
                          type.id = geocache.type AND
                          log.type = logtype.id
                        ORDER BY
                          log.created DESC,
                          log.id DESC");

  $feedUserIds = DB::queryFirstColumn("SELECT
                                         feed.feeduser
                                       FROM
                                         user, feed
                                       WHERE
                                         user.id = feed.user AND
                                         user.username = %s", getSessionUser());

  $sessionResults = DB::queryFirstColumn("SELECT
                                            geocache.gc
                                          FROM
                                            geocache, log, logtype, user, type
                                          WHERE
                                            geocache.id = log.geocache AND
                                            log.user = user.id AND
                                            type.id = geocache.type AND
                                            log.type = logtype.id AND
                                            logtype.type = 'Found it' AND
                                            user.username = %s
                                          ORDER BY
                                            log.created DESC,
                                            log.id ASC", getSessionUser());

  $found = false;
  foreach ($results as $row) {
    if(in_array($row['user.id'], $feedUserIds)) {
      $found = true;
      $name = $row['name'];
      $gc = $row['gc'];
      $created = substr($row['created'], 8, 2).'.'.substr($row['created'], 5, 2).'.'.substr($row['created'], 0, 4);
      $log = $row['log'];
      $logId = $row['log.id'];
      $username = $row['username'];
      $type = $row['type.type'];
      $difficulty = $row['difficulty'];
      $terrain = $row['terrain'];
      $country = $row['country'];
      $url = $row['url'];
      $logType = $row['type'];
      $address = $row['address'];
      $district = $row['district'];
      $lat = $row['lat'];
      $lon = $row['lon'];

      printLogEntry($name, $gc, $type, $created, $log, $logId, $username, $logType, $difficulty, $terrain, $country, $url, $sessionResults, $address, $district, $lat, $lon);
    }
  }
  if(!$found) {
?>
  <div class='panel panel-info'>
    <div class='panel-heading'>Empty feed</div>
    <div class='panel-body'>Your feed is empty, how about adding some users users <a href="settings.php">here</a>?</div>
  </div>
<?
  }
?>
    </div>
    <script type="text/javascript">geolookup();</script>
  </body>
</html>

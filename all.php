<?
  require_once('util/general.php');
  require_once('util/connection.php');
  require_once('util/logger.php');
?>
<!DOCTYPE html>
<html>
<?
  require_once('components/head.html');
  printBodyTag();
  showNavigation();
?>
    <div class="panel-body">
<? if(!isEmbedded()) { ?>
      <div class='panel panel-info'>
        <div class='panel-heading'>Search logs of a user</div>
        <div class='panel-body'>
          <form class="form-inline">
            <div class="form-group">
              <input class="form-control" name="username" placeholder="Username">
            </div>
          </form>
        </div>
      </div>
<? } ?>
<?
  $username = '%';
  if(isset($_GET['username']) && $_GET['username'] != '') {
    $username = urldecode($_GET['username']);
    $finds = DB::queryFirstField("SELECT finds FROM user WHERE username = %s", $username);
    echo "<div class='panel panel-info'>";
    echo "<div class='panel-heading'>Recent logs for <b>$username</b> ($finds)</div>";
?>
    <div class='panel-body' style='padding: 0px;'>
      <div id="map" hidden="hidden"></div>
      <script type="text/javascript">
          $('#map').height(500);
          addRecentStationsFromDb(<? echo "'".$username."'"; ?>);
      </script>
    </div>
  </div>
<?
  }
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
                          geocache.canton,
                          type.type AS 'type.type',
                          log.created,
                          logtype.type,
                          log.log,
                          log.id AS 'log.id',
                          user.username
                        FROM
                          geocache, log, logtype, user, type
                        WHERE
                          geocache.id = log.geocache AND
                          log.user = user.id AND
                          type.id = geocache.type AND
                          log.type = logtype.id AND
                          user.username LIKE %s
                        ORDER BY
                          log.created DESC,
                          log.id DESC", $username);

  if(getSessionUser() != "" && getSessionUser() != $username) {
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
                            log.id DESC", getSessionUser());
  } else {
    $sessionResults = array();
  }

  foreach ($results as $row) {
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
    $canton = $row['canton'];
    $lat = $row['lat'];
    $lon = $row['lon'];

    printLogEntry($name, $gc, $type, $created, $log, $logId, $username, $logType, $difficulty, $terrain, $country, $url, $sessionResults, $address, $canton, $lat, $lon);
  }
?>
    </div>
    <script type="text/javascript">geolookup();</script>
  </body>
</html>

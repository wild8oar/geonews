<?
  require_once('general.php');
  require_once('connection.php');
  require_once('logger.php');
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
  if((isset($_GET['username']) && $_GET['username'] != '') || getSessionUser() != "") {
    if(isset($_GET['username']) && $_GET['username'] != '') {
      $username = urldecode($_GET['username']);
    } else {
      $username = getSessionUser();
    }

    if(getSessionUser() != "") {
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
                              user.username = %s AND
                              month(curdate()) = month(created) AND
                              day(curdate()) = day(created) AND
                              year(curdate()) != year(created)
                            ORDER BY
                              log.created DESC,
                              log.id DESC", getSessionUser());
    } else {
      $sessionResults = array();
    }

    $finds = DB::queryFirstField("SELECT finds FROM user WHERE username = %s", $username);
    echo "<div class='panel panel-info'>";
    $month = date('m');
    $day = date('d');
    echo "<div class='panel-heading'>On this day of <b>$username</b> ($finds)</div>";
    echo "</div>";
  } else {
    echo "<div class='panel panel-info'>";
    $month = date('m');
    $day = date('d');
    echo "<div class='panel-heading'>On this day of all indexed users</div>";
    echo "</div>";
    $username = '%';
    $sessionResults = array();
  }
  $results = DB::query("SELECT
                          geocache.name,
                          geocache.gc,
                          geocache.difficulty,
                          geocache.terrain,
                          geocache.favorites,
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
                          user.avatar
                        FROM
                          geocache, log, logtype, user, type
                        WHERE
                          geocache.id = log.geocache AND
                          log.user = user.id AND
                          type.id = geocache.type AND
                          log.type = logtype.id AND
                          user.username = %s AND
                          month(curdate()) = month(created) AND
                          day(curdate()) = day(created) AND
                          year(curdate()) != year(created)
                        ORDER BY
                          log.created DESC,
                          log.id ASC", $username);

  foreach ($results as $row) {
    $name = $row['name'];
    $gc = $row['gc'];
    $created = substr($row['created'], 8, 2).'.'.substr($row['created'], 5, 2).'.'.substr($row['created'], 0, 4);
    $log = $row['log'];
    $logId = $row['log.id'];
    $username = $row['username'];
    $avatar = $row['avatar'];
    $type = $row['type.type'];
    $difficulty = $row['difficulty'];
    $terrain = $row['terrain'];
    $country = $row['country'];
    $favorites = $row['favorites'];
    $url = $row['url'];
    $logType = $row['type'];
    $address = $row['address'];
    $district = $row['district'];
    $lat = $row['lat'];
    $lon = $row['lon'];

    printLogEntry(false, $name, $gc, $type, $created, $log, $logId, $username, $logType, $difficulty, $terrain, $country, $favorites, $url, array(), $address, $district, $lat, $lon, $avatar);
  }
?>
    </div>
  <script type="text/javascript">geolookup();</script>
  </body>
</html>

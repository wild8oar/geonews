<?
  require_once('util/general.php');
  require_once('util/connection.php');
  require_once('util/logger.php');
  require_once('util/types.php');
?>
<!DOCTYPE html>
<html>
<? require_once('include/head.html'); ?>
   <body>
<? showNavigation(); ?>
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
                          type.type as 'type.type',
                          log.created,
                          logtype.type,
                          log.log,
                          log.id as 'log.id',
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

    $gif = determineTypeIcon($type);
    $difficultyString = ratingToStars("D:", $difficulty);
    $terrainString = ratingToStars("T:", $terrain);
    $countryImage = countryToImage($country);
    $logType = determineLogTypeIcon($logType);

    $images = DB::queryFirstColumn("SELECT
                                           url
                                         FROM
                                           image
                                         WHERE
                                           image.log = %i", $logId);

    printLogEntry($name, $gc, $gif, $created, $log, $username, $logType, $difficultyString, $terrainString, $countryImage, $url, $sessionResults, $images);
  }

  function printLogEntry($name, $gc, $gif, $created, $log, $username, $logType, $difficulty, $terrain, $countryImage, $url, $sessionResults, $images) {
    if($created == date('d.m.Y')) {
      echo "<div class='panel panel-primary'>";
      echo "<div class='panel-heading'><a style='color: white;' href='$url'><b>$name</b> - $gc</a> <img src='icons/$gif' width='23px' /> ($difficulty $terrain) $countryImage</div>";
    } else {
      echo "<div class='panel panel-info'>";
      echo "<div class='panel-heading'><a href='$url'><b>$name</b> - $gc</a> <img src='icons/$gif' width='23px' /> ($difficulty $terrain) $countryImage</div>";
    }
    echo "<div class='panel-body'>$log</div>";
    if(!empty($images)) {
      echo "<div class='panel-body'>";
      foreach($images as $image) {
        echo '<img class="img-rounded" height="300px" src="'.$image.'" />&nbsp;&nbsp;';
      }
      echo "</div>";
    }
    $urlencodedUsername = urlencode($username);
    if(in_array($gc, $sessionResults) && $username != getSessionUser()) {
      echo "<div class='panel-footer'><a href='all.php?username=$urlencodedUsername'>$username</a> $logType $created. (You <i class='fa fa-thumbs-up'></i> this one too.)</div>";
    } else {
      echo "<div class='panel-footer'><a href='all.php?username=$urlencodedUsername'>$username</a> $logType $created.</div>";
    }
    echo "</div>";
  }
?>
    </div>
  </body>
</html>

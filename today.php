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
                              curdate() != created
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
    echo "<div class='panel-heading'>Logs of $day.$month. (today) in past years of <b>$username</b> ($finds)</div>";
    echo "</div>";
  } else {
    echo "<div class='panel panel-info'>";
    $month = date('m');
    $day = date('d');
    echo "<div class='panel-heading'>Logs of $day.$month. (today) in past years of all indexed users</div>";
    echo "</div>";
    $username = '%';
    $sessionResults = array();
  }
  $results = DB::query("SELECT
                          geocache.name,
                          geocache.gc,
                          geocache.difficulty,
                          geocache.terrain,
                          geocache.url,
                          type.type as 'type.type',
                          log.created,
                          logtype.type,
                          log.log,
                          user.username
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
                          curdate() != created
                        ORDER BY
                          log.created DESC,
                          log.id ASC", $username);

  foreach ($results as $row) {
    $name = $row['name'];
    $gc = $row['gc'];
    $created = substr($row['created'], 8, 2).'.'.substr($row['created'], 5, 2).'.'.substr($row['created'], 0, 4);
    $log = $row['log'];
    $username = $row['username'];
    $type = $row['type.type'];
    $difficulty = $row['difficulty'];
    $terrain = $row['terrain'];
    $url = $row['url'];
    $logType = $row['type'];

    $gif = determineTypeIcon($type);
    $difficultyString = ratingToStars("D:", $difficulty);
    $terrainString = ratingToStars("T:", $terrain);
    $logType = determineLogTypeIcon($logType);

    printLogEntry($name, $gc, $gif, $created, $log, $username, $logType, $difficultyString, $terrainString, $url, $sessionResults);
  }

  function printLogEntry($name, $gc, $gif, $created, $log, $username, $logType, $difficulty, $terrain, $url, $sessionResults) {
    echo "<div class='panel panel-info'>";
    echo "<div class='panel-heading'><a href='$url'><b>$name</b> - $gc</a> <img src='icons/$gif' width='23px' /> ($difficulty $terrain)</div>";
    echo "<div class='panel-body'>$log</div>";
    if(in_array($gc, $sessionResults) && $username != getSessionUser()) {
      echo "<div class='panel-footer'>$username $logType $created. (You <i class='fa fa-thumbs-up'></i> this one too.)</div>";
    } else {
      echo "<div class='panel-footer'>$username $logType $created.</div>";
    }
    echo "</div>";
  }
?>
    </div>
  </body>
</html>

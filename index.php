<?
  require_once('util/connection.php');
  require_once('util/logger.php');
  require_once('util/types.php');
?>
<!DOCTYPE html>
<html>
<? require_once('include/head.html'); ?>
   <body>
<? require_once('include/navigation.html'); ?>
   <div class="panel-body">
<?
  if(getSessionUser() == "") {
?>
    <div class='panel panel-info'>
      <div class='panel-heading'>Not logged in</div>
      <div class='panel-body'>Please 'log in' on the top right corner.</div>
    </div>
<?
  } else {
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
                            log.id as 'log.id',
                            user.username,
                            user.id
                          FROM
                            geocache, log, logtype, user, type
                          WHERE
                            geocache.id = log.geocache AND
                            log.user = user.id AND
                            type.id = geocache.type AND
                            log.type = logtype.id
                          ORDER BY
                            log.created DESC,
                            log.id DESC
                          LIMIT 50");

    $username = getSessionUser();

    $feedUserIds = DB::queryFirstColumn("SELECT
                                           feed.feeduser
                                         FROM
                                           user, feed
                                         WHERE
                                           user.id = feed.user AND
                                           user.username = %s", $username);

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
                                              log.id ASC", $username);

    $found = false;
    foreach ($results as $row) {
      if(in_array($row['id'], $feedUserIds)) {
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
        $url = $row['url'];
        $logType = $row['type'];

        $gif = determineTypeIcon($type);
        $difficultyString = ratingToStars("D:", $difficulty);
        $terrainString = ratingToStars("T:", $terrain);
        $logType = determineLogTypeIcon($logType);

        $images = DB::queryFirstColumn("SELECT
                                               url
                                             FROM
                                               image
                                             WHERE
                                               image.log = %i", $logId);
        printLogEntry($name, $gc, $gif, $created, $log, $username, $logType, $difficultyString, $terrainString, $url, $sessionResults, $images);
      }
    }
    if(!$found) {
?>
      <div class='panel panel-info'>
        <div class='panel-heading'>Empty feed</div>
        <div class='panel-body'>Your feed is empty, how about adding some users users <a href="editFeed.php">here</a>?</div>
      </div>
<?
    }
  }

  function printLogEntry($name, $gc, $gif, $created, $log, $username, $logType, $difficulty, $terrain, $url, $sessionResults, $images) {
    echo "<div class='panel panel-info'>";
    echo "<div class='panel-heading'><a href='$url'><b>$name</b> - $gc</a> <img src='icons/$gif' width='23px' /> ($difficulty $terrain)</div>";
    echo "<div class='panel-body'>$log</div>";
    if(!empty($images)) {
      echo "<div class='panel-body'>";
      foreach($images as $image) {
        echo '<img class="img-rounded" height="300px" src="'.$image.'" />&nbsp;&nbsp;';
      }
      echo "</div>";
    }
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

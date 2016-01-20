<?
  require_once('util/general.php');
  require_once('util/connection.php');
  require_once('util/logger.php');
  require_once('util/types.php');
?>
<!DOCTYPE html>
<html>
<?
  require_once('include/head.html');
  printBodyTag();
  showNavigation();
?>
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
                            geocache.country,
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
        $country = $row['country'];
        $url = $row['url'];
        $logType = $row['type'];

        $gif = determineTypeIcon($type);
        $difficultyString = ratingToStars("D:", $difficulty);
        $terrainString = ratingToStars("T:", $terrain);
        $countryImage = countryToImage($country);
        $logType = determineLogTypeIcon($logType);

        printLogEntry($name, $gc, $gif, $created, $log, $logId, $username, $logType, $difficultyString, $terrainString, $countryImage, $url, $sessionResults);
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
  }
?>
    </div>
  </body>
</html>

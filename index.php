<?
  require_once('util/general.php');
  require_once('util/connection.php');
  require_once('util/logger.php');
  require_once('util/checkLogin.php');
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

  foreach ($results as $row) {
    if(in_array($row['user.id'], $feedUserIds)) {
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

      printLogEntry($name, $gc, $type, $created, $log, $logId, $username, $logType, $difficulty, $terrain, $country, $url, $sessionResults);
    }
  }
?>
    </div>
  </body>
</html>

<?
  require_once('util/connection.php');

  if(isset($_GET['recent']) && $_GET['recent'] == 'true') {
    $results = DB::query("SELECT
                            geocache.name,
                            geocache.gc,
                            geocache.lat,
                            geocache.lon,
                            geocache.url,
                            type.type,
                            log.created
                          FROM
                            geocache, log, user, type
                          WHERE
                            geocache.id = log.geocache AND
                            log.user = user.id AND
                            user.username = %s AND
                            geocache.type = type.id AND
                            geocache.lat != 0 AND
                            geocache.lon != 0
                          ORDER BY
                            log.created DESC,
                            log.id ASC
                          LIMIT 20", $_GET['username']);
    echo json_encode($results);
  } else {
    $results = DB::query("SELECT
                            geocache.name,
                            geocache.gc,
                            geocache.lat,
                            geocache.lon,
                            geocache.url,
                            type.type,
                            log.created
                          FROM
                            geocache, log, user, type
                          WHERE
                            geocache.id = log.geocache AND
                            log.user = user.id AND
                            user.username = %s AND
                            geocache.type = type.id AND
                            geocache.lat != 0 AND
                            geocache.lon != 0
                          ORDER BY
                            log.created DESC,
                            log.id ASC", $_GET['username']);

    echo json_encode($results);
  }
?>

<?
  require_once('connection.php');

  if(isset($_GET['mode']) && $_GET['mode'] == 'recent') {
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
    echo json_encode($results, JSON_NUMERIC_CHECK);
  } else if(isset($_GET['mode']) && $_GET['mode'] == 'geolookup') {
    $results = DB::query("SELECT
                            geocache.gc,
                            geocache.lat,
                            geocache.lon,
                            geocache.country,
                            geocache.address
                          FROM
                            geocache, log
                          WHERE
                            (
                              geocache.id = log.geocache AND
                              geocache.lat IS NOT NULL AND
                              geocache.lon IS NOT NULL AND
                              geocache.address IS NULL
                            ) OR (
                              geocache.id = log.geocache AND
                              geocache.lat IS NOT NULL AND
                              geocache.lon IS NOT NULL AND
                              geocache.canton IS NULL AND
                              geocache.country = 'Switzerland'
                            )
                          ORDER BY
                            log.created DESC
                          LIMIT 5");
    echo json_encode($results, JSON_NUMERIC_CHECK);
  } else if(isset($_GET['mode']) && $_GET['mode'] == 'save_geolookup') {
    DB::update('geocache', array(
      'address' => urldecode($_GET['address'])
    ), "gc=%s", urldecode($_GET['gc']));
  } else if(isset($_GET['mode']) && $_GET['mode'] == 'save_canton') {
    DB::update('geocache', array(
      'canton' => urldecode($_GET['canton'])
    ), "gc=%s", urldecode($_GET['gc']));
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

    echo json_encode($results, JSON_NUMERIC_CHECK);
  }
?>

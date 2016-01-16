<?
  require_once('util/connection.php');

  $username = $_GET['username'];

  if($_GET['data'] == 'allYearLabels') {
    echo json_encode(DB::queryFirstColumn("SELECT DISTINCT
                                              year(created)
                                            FROM
                                              log, user
                                            WHERE
                                              log.user = user.id AND
                                              user.username = %s
                                              ORDER BY year(created) ASC", $username));
  } else if($_GET['data'] == 'allYearData') {
    echo json_encode(DB::queryFirstColumn("SELECT
                                             COUNT(*)
                                           FROM
                                             log,
                                             user,
                                             logtype
                                           WHERE
                                             log.user = user.id AND
                                             user.username = %s AND
                                             log.type = logtype.id AND
                                             logtype.type = 'Found it'
                                           GROUP BY year(created)
                                           ORDER BY year(created) ASC", $username));
  } else if($_GET['data'] == 'allTypesData') {
    $results = DB::query("SELECT
                           type.type,
                           COUNT(*) AS cnt
                         FROM
                           log,
                           geocache,
                           user,
                           type
                         WHERE
                           log.user = user.id AND
                           user.username = %s AND
                           geocache.type = type.id AND
                           log.geocache = geocache.id
                         GROUP BY type.type
                         ORDER BY type.id ASC", $username);

    $colors = array("#347880", "#4496a1", "97c7a6", "#eaf8ab", "#dbe694", "#ccd47e", "#b5c653", "#9fb828", "#cde0db", "#255a60");

    $out = "[";
    $i = 0;
    foreach ($results as $row) {
      $out = $out."{";
      $out = $out."\"value\": ".$row['cnt'].", \"color\": \"".$colors[$i]."\", \"label\": \"".$row['type']."\"";
      $out = $out."}, ";
      $i++;
    }
    $out = rtrim($out, ", ");
    $out = $out."]";
    echo $out;
  } else if($_GET['data'] == 'lastYearData') {
    $results =       DB::query("SELECT
                                   month(created) as month,
                                   count(month(created)) as cnt
                                 FROM
                                   log,
                                   user,
                                   logtype
                                 WHERE
                                   log.user = user.id AND
                                   user.username = %s AND
                                   log.type = logtype.id AND
                                   logtype.type = 'Found it' AND
                                   year(log.created) = year(now())-1
                                 GROUP BY month(created)
                                 ORDER BY created", $username);

    $out = "[";
    for ($i = 0; $i <= 11; $i++) {
      $found = false;
      foreach ($results as $row) {
        if($row['month'] == $i + 1) {
          $found = true;
          $out = $out.$row['cnt'].", ";
        }
      }
      if(!$found) {
        $out = $out."0, ";
      }
    }

    $out = rtrim($out, ", ");
    $out = $out."]";
    echo $out;
  } else if($_GET['data'] == 'thisYearData') {
    $results =       DB::query("SELECT
                                   month(created) as month,
                                   count(month(created)) as cnt
                                 FROM
                                   log,
                                   user,
                                   logtype
                                 WHERE
                                   log.user = user.id AND
                                   user.username = %s AND
                                   log.type = logtype.id AND
                                   logtype.type = 'Found it' AND
                                   year(log.created) = year(now())
                                 GROUP BY month(created)
                                 ORDER BY created", $username);

    $out = "[";
    for ($i = 0; $i <= 11; $i++) {
      $found = false;
      foreach ($results as $row) {
        if($row['month'] == $i + 1) {
          $found = true;
          $out = $out.$row['cnt'].", ";
        }
      }
      if(!$found) {
        $out = $out."0, ";
      }
    }

    $out = rtrim($out, ", ");
    $out = $out."]";
    echo $out;
  }
?>

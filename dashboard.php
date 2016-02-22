<?
  require_once('general.php');
  require_once('connection.php');
  require_once('logger.php');
  require_once('checkLogin.php');
?>
<!DOCTYPE html>
<html>
<?
  require_once('components/head.html');
  printBodyTag();
  showNavigation();
?>
    <div class="panel-body">
      <div class="row">
        <div class="col-sm-6 col-sm-push-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><a href="memories.php"><i class="fa fa-calendar"></i> On this day</a></h3>
            </div>
            <div class="panel-body" style="padding: 5px; padding-bottom: 0px;">
<?
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
                                      log.id ASC", getSessionUser());

              foreach ($results as $row) {
                $name = $row['name'];
                $gc = $row['gc'];
                $created = substr($row['created'], 8, 2).'.'.substr($row['created'], 5, 2).'.'.substr($row['created'], 0, 4);
                $log = str_replace("/images/icons/", "https://www.geocaching.com/images/icons/", $row['log']);
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

                printLogEntry(true, $name, $gc, $type, $created, $log, $logId, $username, $logType, $difficulty, $terrain, $favorites, $country, $url, array(), $address, $district, $lat, $lon, $avatar);
              }
?>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><a href="chart.php"><i class="fa fa-bar-chart"></i> Statistics (last vs current year)</a></h3>
            </div>
            <div class="panel-body" style="padding: 5px; padding-bottom: 0px;">
              <canvas id="yearComparison"></canvas>
            </div>
          </div>
        </div>
          <div class="col-sm-6 col-sm-pull-6">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h3 class="panel-title"><a href="index.php"><i class="fa fa-rss"></i> News</a></h3>
              </div>
              <div class="panel-body" style="padding: 5px; padding-bottom: 0px;">
                <?
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
                                          user.avatar,
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
                                          log.id DESC
                                        LIMIT 20");

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
                                                            (logtype.type = 'Found it' OR logtype.type = 'Attended' OR logtype.type = 'Webcam Photo Taken') AND
                                                            user.username = %s
                                                          ORDER BY
                                                            log.created DESC,
                                                            log.id ASC", getSessionUser());

                  $found = false;
                  foreach ($results as $row) {
                    if(in_array($row['user.id'], $feedUserIds)) {
                      $found = true;
                      $name = $row['name'];
                      $gc = $row['gc'];
                      $created = substr($row['created'], 8, 2).'.'.substr($row['created'], 5, 2).'.'.substr($row['created'], 0, 4);
                      $log = str_replace("/images/icons/", "https://www.geocaching.com/images/icons/", $row['log']);
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

                      printLogEntry(true, $name, $gc, $type, $created, $log, $logId, $username, $logType, $difficulty, $terrain, $favorites, $country, $url, $sessionResults, $address, $district, $lat, $lon, $avatar);
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
                ?>
              </div>
            </div>
          </div>
      </div>
    </div>
    <script>
      var username = "<?php echo getSessionUser(); ?>";

      $.getJSON("chartapi.php?data=thisYearData&username=" + encodeURIComponent(username), function(thisYearData) {
        $.getJSON("chartapi.php?data=lastYearData&username=" + encodeURIComponent(username), function(lastYearData) {
          var yearComparisonChart = {
            labels : ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            datasets : [
              {
                fillColor : "rgba(220,220,220,0.5)",
                strokeColor : "rgba(220,220,220,0.8)",
                highlightFill: "rgba(220,220,220,0.75)",
                highlightStroke: "rgba(220,220,220,1)",
                data : lastYearData
              },
              {
                fillColor : "rgba(151,187,205,0.5)",
                strokeColor : "rgba(151,187,205,0.8)",
                highlightFill : "rgba(151,187,205,0.75)",
                highlightStroke : "rgba(151,187,205,1)",
                data : thisYearData
              }
            ]
          };

        var ctx2 = document.getElementById("yearComparison").getContext("2d");
        window.myBar = new Chart(ctx2).Bar(yearComparisonChart, {
          responsive : true,
          scaleShowVerticalLines : false,
          animationSteps : 100,
          scaleFontSize: 12,
          datasetFill : false
          });
        });
      });

    </script>
    <script type="text/javascript">geolookup();</script>
  </body>
</html>

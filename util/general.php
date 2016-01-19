<?
  function showNavigation() {
    if(!isset($_GET['embedded']) || !$_GET['embedded']) {
      require_once('include/navigation.html');
    }
  }

  function isEmbedded() {
    return isset($_GET['embedded']) && $_GET['embedded'];
  }

  function printLogEntry($name, $gc, $gif, $created, $log, $logId, $username, $logType, $difficulty, $terrain, $countryImage, $url, $sessionResults) {
    $images = DB::queryFirstColumn("SELECT
                                           url
                                         FROM
                                           image
                                         WHERE
                                           image.log = %i", $logId);

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
        echo '<img class="img-rounded" style="max-width: 100%;" src="'.$image.'" />&nbsp;&nbsp;';
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

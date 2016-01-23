<?
  function showNavigation() {
    if(!isset($_GET['embedded']) || !$_GET['embedded']) {
      require_once('components/navigation.html');
    }
  }

  function printBodyTag() {
    if(isEmbedded()) {
      echo '<body>';
    } else {
      echo '<body style="padding-top: 50px;">';
    }
  }

  function isEmbedded() {
    return isset($_GET['embedded']) && $_GET['embedded'];
  }

  function printLogEntry($name, $gc, $type, $created, $log, $logId, $username, $logType, $difficulty, $terrain, $country, $url, $sessionResults) {
    $type = determineTypeIcon($type);
    $difficulty = ratingToStars("D:", $difficulty);
    $terrain = ratingToStars("T:", $terrain);
    $country = countryToImage($country);
    $logType = determineLogTypeIcon($logType);

    $images = DB::queryFirstColumn("SELECT
                                           url
                                         FROM
                                           image
                                         WHERE
                                           image.log = %i", $logId);

    if($created == date('d.m.Y')) {
      echo "<div class='panel panel-primary'>";
      echo "<div class='panel-heading'><a style='color: white;' href='$url'><b>$name</b> - $gc</a> <img src='res/icons/$type' width='20px' /> ($difficulty $terrain) $country</div>";
    } else {
      echo "<div class='panel panel-info'>";
      echo "<div class='panel-heading'><a href='$url'><b>$name</b> - $gc</a> <img src='res/icons/$type' width='20px' /> ($difficulty $terrain) $country</div>";
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
  function determineLogTypeIcon($logType) {
    switch($logType) {
      case "Didn't find it": return "<i class='fa fa-thumbs-down'></i>";
      case "Write note": return "<i class='fa fa-sticky-note'></i>";
      case "Found it": return "<i class='fa fa-thumbs-up'></i>";
      case "Publish Listing": return "<i class='fa fa-plus'></i>";
      case "Archive": return "<i class='fa fa-trash'></i>";
      case "Will Attend": return "<i class='fa fa-calendar'></i>";
      case "Attended": return "<i class='fa fa-calendar-check-o'></i>";
      case "Webcam Photo Taken": return "<i class='fa fa-camera'></i>";
    }
  }

  function determineTypeIcon($type) {
    switch($type) {
      case 'Multi-cache': return 'multi.png';
      case 'Unknown Cache': return 'unknown.png';
      case 'Traditional Cache': return 'traditional.png';
      case 'Wherigo Cache': return 'wherigo.png';
      case 'Earthcache': return 'earthcache.png';
      case 'Virtual Cache': return 'virtual.png';
      case 'Letterbox Hybrid': return 'letterbox.png';
      case 'Webcam Cache': return 'webcam.gif';
      case 'Event Cache': return 'event.gif';
      case 'unknown': return 'unknown.gif';
    }
  }

  function ratingToStars($prefix, $value) {
    switch($value) {
      case '1': return $prefix.' <i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
      case '1.5': return $prefix.' <i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
      case '2': return $prefix.' <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
      case '2.5': return $prefix.' <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
      case '3': return $prefix.' <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
      case '3.5': return $prefix.' <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i>';
      case '4': return $prefix.' <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>';
      case '4.5': return $prefix.' <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i>';
      case '5': return $prefix.' <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
    }
  }

  function countryToImage($country) {
    if($country == '') {
      return '';
    }
    return "<img class='flagSmall' src='res/icons/countries/$country.gif'/>";
  }
?>

<?
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
?>

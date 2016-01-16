<?
  function l($str) {
    echo $str.'<br />';
    ob_flush();
    flush();
  }

  function logStatistics($statistics) {
    l('-----------------------------------------------------------------------------------------');
    foreach($statistics as $key => $value) {
      l("$key: $value");
    }
    l('-----------------------------------------------------------------------------------------');
  }
?>

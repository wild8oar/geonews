<?
  function showNavigation() {
    if(!isset($_GET['embedded']) || !$_GET['embedded']) {
      require_once('include/navigation.html');
    }
  }

  function isEmbedded() {
    return isset($_GET['embedded']) && $_GET['embedded'];
  }
?>

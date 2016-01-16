<?
  require_once('util/connection.php');
  require_once('util/logger.php');
?>
<!DOCTYPE html>
<html>
<? require_once('include/head.html'); ?>
   <body>
<? require_once('include/navigation.html'); ?>
    <div id="no-gpx" class="panel-body" hidden="hidden">
      <div class='panel panel-info'>
        <div class='panel-heading'>No geocaches with location data found</div>
        <div class='panel-body'>None of the geocaches you have found contain location data. Upload your finds <a href="upload.php">here</a>.</div>
      </div>
    </div>
<?
  if(getSessionUser() == "") {
?>
    <div id="not-logged-in" class="panel-body">
      <div class='panel panel-info'>
        <div class='panel-heading'>Not logged in</div>
        <div class='panel-body'>Please 'log in' on the top right corner.</div>
      </div>
    </div>
<?
  } else {
?>
    <div id="map" hidden="hidden"></div>
    <script type="text/javascript">
        $('#map').height($(window).height() - 72);
        addStationsFromDb(<? echo "'".getSessionUser()."'"; ?>);
    </script>
<?
  }
?>
    </body>
</html>

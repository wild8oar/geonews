<?
  require_once('util/general.php');
  require_once('util/connection.php');
  require_once('util/logger.php');
  require_once('util/checkLogin.php');
?>
<!DOCTYPE html>
<html>
<?
  require_once('components/head.html');
  printBodyTag();
  showNavigation();
?>
    <div id="no-gpx" class="panel-body" hidden="hidden">
      <div class='panel panel-info'>
        <div class='panel-heading'>No geocaches with location data found</div>
        <div class='panel-body'>None of the geocaches you have found contain location data. Upload your finds <a href="upload.php">here</a>.</div>
      </div>
    </div>
    <div id="map" hidden="hidden"></div>
<?
  if(isEmbedded()) {
?>
    <script type="text/javascript">
        $('#map').height($(window).height());
        addStationsFromDb(<? echo "'".getSessionUser()."'"; ?>);
    </script>
<?
  } else {
?>
    <script type="text/javascript">
        $('#map').height($(window).height() - 52);
        addStationsFromDb(<? echo "'".getSessionUser()."'"; ?>);
    </script>
<?
  }
?>
    </body>
</html>

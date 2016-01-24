<?
  require_once('util/general.php');
  require_once('util/connection.php');
?>
<!DOCTYPE html>
<html>
<?
  require_once('components/head.html');
  printBodyTag();
  showNavigation();
?>
    <div class="panel-body">
      <div class='panel panel-info'>
        <div class='panel-heading'>Not logged in</div>
        <div class='panel-body'>Please 'log in'.</div>
      </div>
    </div>
    <script type="text/javascript">geolookup();</script>
  </body>
</html>

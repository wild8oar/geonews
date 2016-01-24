<?
  require_once('general.php');
  require_once('connection.php');
  require_once('logger.php');

  if(isset($_POST["submit"])) {
    $target_file = realpath(dirname(__FILE__))."/pocketquery.gpx";
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      header("Location: processFile.php");
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
?>
<!DOCTYPE html>
<html>
<?
  require_once('components/head.html');
  printBodyTag();
  showNavigation();
?>
   <div class="panel-body">
<?
  if(getSessionUser() == "") {
?>
    <div class='panel panel-info'>
      <div class='panel-heading'>Not logged in</div>
      <div class='panel-body'>Please 'log in' on the top right corner.</div>
    </div>
<?
  } else {
?>
      <div class='panel panel-info'>
        <div class='panel-heading'>Upload the pocket query with your finds. Your crawled and previously uploaded logs will be deleted.</div>
        <div class='panel-body'>
          <form method="POST" enctype="multipart/form-data" id="pocketQueryForm">
            <span class="btn btn-default btn-file">Browse <input type="file" name="fileToUpload" id="fileToUpload"></span>
            <div hidden="hidden">
              <button id="submit" type="submit" name="submit" class="btn btn-default" aria-label="Left Align">
                <span class="glyphicon glyphicon glyphicon-upload" aria-hidden="true"></span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(document).ready(function() {
        $("#fileToUpload").change(function(){
          $("#submit").click();
        });
      });
    </script>
<?
  }
?>
    </div>
  </body>
</html>

<?
  require_once('util/general.php');
  require_once('util/connection.php');
  require_once('util/logger.php');

  if(getSessionUser() != "") {
    if(isset($_GET['addUser'])) {
      DB::insertUpdate('user', array(
        'username' => $_GET['addUser']
      ));

      DB::insertIgnore('feed', array(
        'user' => DB::queryFirstField("SELECT id FROM user WHERE username = %s", getSessionUser()),
        'feeduser' => DB::queryFirstField("SELECT id FROM user WHERE username = %s", $_GET['addUser'])
      ));
    } else if(isset($_GET['removeUser'])) {
      $user = DB::queryFirstField("SELECT id FROM user WHERE username = %s", getSessionUser());
      $feedUser = DB::queryFirstField("SELECT id FROM user WHERE username = %s", $_GET['removeUser']);

      DB::delete('feed', 'user=%s AND feeduser='.$feedUser, $user);
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
        <div class='panel-heading'>Add user to feed and index</div>
        <div class='panel-body'>
          <form class="form-inline">
            <div class="form-group">
              <input class="form-control" name="addUser" placeholder="Username">
            </div>
          </form>
        </div>
      </div>
      <div class='panel panel-info'>
        <div class='panel-heading'>Remove user from feed</div>
        <div class='panel-body'>
          <form class="form-inline">
            <div class="form-group">
              <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  Remove user
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
<?
  $users = DB::queryFirstColumn("SELECT
                                   u2.username
                                 FROM
                                   user u1, feed, user u2
                                 WHERE
                                   feed.user = u1.id AND
                                   u1.username = %s AND
                                   u2.id = feed.feeduser", getSessionUser());
  foreach ($users as $user) {
    echo '<li><a href="?removeUser='.urlencode($user).'">'.$user.'</a></li>';
  }
?>
                </ul>
              </div>
            </div>
          </form>
        </div>
      </div>
<?
    }
?>
    </div>
  </body>
</html>

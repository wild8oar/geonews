<?
  require_once('meekro.php');
  require_once('passwords.php');
  DB::$user = 'musharos_geonews';
  DB::$password = $DB_PASSWORD;
  DB::$dbName = 'musharos_geonews';

  function printLoggedInUser() {
    if(isset($_COOKIE['geonews'])) {
      $avatar = DB::queryOneField('avatar', 'SELECT avatar FROM user WHERE username = %s', $_COOKIE['geonews']);
      echo "<img style='border: 1px solid black; height: 25px; margin-bottom: -10px; margin-top: -10px;' src='$avatar' /> ".$_COOKIE['geonews'];
    } else {
      echo "<i class='fa fa-user'> Log in";
    }
  }

  function getSessionUser() {
    if(isset($_COOKIE['geonews'])) {
      return $_COOKIE['geonews'];
    }
    return "";
  }

  function printAllUsers() {
    $users = DB::query("SELECT id, username FROM user");
    foreach ($users as $user) {
      $username = $user['username'];
      $urlEncodedUsername = urlencode($username);
      echo "<li><a href='login.php?username=$urlEncodedUsername'>$username</a></li>";
    }
  }
?>

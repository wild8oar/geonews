<?
  require_once('meekro.php');
  require_once('util/passwords.php');
  DB::$user = 'musharos_geonews';
  DB::$password = $DB_PASSWORD;
  DB::$dbName = 'musharos_geonews';

  function printLoggedInUser() {
    if(isset($_COOKIE['geonews'])) {
      echo $_COOKIE['geonews'];
    } else {
      echo "Log in";
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

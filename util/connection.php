<?
  require_once('meekro.php');
  DB::$user = 'musharos_geonews';
  DB::$password = 'GaU+7zUa+3TU#3d';
  DB::$dbName = 'musharos_geonews';

  function resetDb() {
    l('resetted db');
    DB::query('DELETE FROM log');
    DB::query('DELETE FROM geocache');
  }

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
      echo "<li><a href='setUsername.php?username=$urlEncodedUsername'>$username</a></li>";
    }
  }
?>

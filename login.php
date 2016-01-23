<?
  setcookie('geonews', $_GET['username'], time() + (31622400), "/");
  if(strpos($_SERVER['HTTP_REFERER'], "notLoggedIn.php")) {
    header('Location: index.php');
  } else {
    header('Location: '.$_SERVER['HTTP_REFERER']);
  }
?>

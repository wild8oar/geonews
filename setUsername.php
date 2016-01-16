<?
  setcookie('geonews', $_GET['username'], time() + (31622400), "/");
  header('Location: '.$_SERVER['HTTP_REFERER']);
?>

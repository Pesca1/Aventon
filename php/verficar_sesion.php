<?php

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
}else{
  header("Location: /index.php?no_session");
  exit;
}
$now = time();
if ($now > $_SESSION['expire']){
  session_destroy();
  header("Location: /index.php?session_expire");
}else {
  $_SESSION['expire'] = time() + 20 * 60;
}

 ?>

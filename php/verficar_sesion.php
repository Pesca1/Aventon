<?php

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
}else{
  header("Location: /index.php");
  exit;
}
$now = time();
if ($now > $_SESSION['expire']){
  session_destroy();
  echo "su sesion terminó";
}else {
  $_SESSION['expire'] = time() + 5 * 60;
}

 ?>

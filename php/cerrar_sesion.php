<?php

  session_start();
  unset($_SESSION['user_mail']);
  session_destroy();
  header('location: /index.php');

 ?>

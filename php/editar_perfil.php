<?php
  session_start();
  ob_start();
  $user_mail = $_POST['edit_mail'];
  $user_name = $_POST['edit_name'];
  $user_surname = $_POST['edit_surname'];
  $user_id = $_SESSION['user_id'];
  include("abrir_conexion.php");

  if ($user_mail == ''){
    $user_mail = $_SESSION['user_mail'];
  }
  if ($user_name == ''){
    $user_name = $_SESSION['user_name'];
  }
  if ($user_surname == ''){
    $user_surname = $_SESSION['user_surname'];
  }

  $sSQL="Update usuario Set nombre='$user_name', apellido='$user_surname',
                            mail='$user_mail' Where id_usuario='$user_id'";
  mysqli_query($conn, $sSQL);
  include("cerrar_conexion.php");
  header("Location: /pantalla_principal.php");
 ?>

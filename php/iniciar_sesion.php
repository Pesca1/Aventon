<?php
  session_start();
  ob_start();
  $_SESSION['session_state'] = 0;

  $user_mail = $_POST['mail'];
  $user_pass = $_POST['password'];
  if ($user_mail == "" || $user_pass == "" )
  {
      $_SESSION['session_state'] = 2; // 2 es campo vacio
  }
  else
  {
    include("abrir_conexion.php");
    $table_user = "usuario";
    $query = "SELECT * from $table_user WHERE mail = '$user_mail' AND contrasenia = '$user_pass'";
    $_SESSION['session_state'] = 3; // 3 es datos incorrectos
    $result = mysqli_query($conn, $query);

    while($consult = mysqli_fetch_assoc($result))
    {
      $_SESSION['session_state'] = 1; // 1 es sesion correcta
    }
    include("cerrar_conexion.php");
  }
  if ($_SESSION['session_state'] <> 1 )
  {
    header('location:../index.php');
  }

 ?>

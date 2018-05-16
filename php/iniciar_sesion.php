<?php

  session_start();
  ob_start();
  $_SESSION['session_state'] = 0;

  $user_mail = $_POST['mail'];
  $user_pass = $_POST['password'];

  include("abrir_conexion.php");

  $query = "SELECT * from $table_user WHERE mail = '$user_mail' AND contrasenia = '$user_pass'";
  $result = mysqli_query($conn, $query);

  //si la consulta tiene alguna fila es que retorno un resultado, que es el correcto
  //creo la sesion con los datos necesarios
  if (mysqli_num_rows($result) > 0) {
    $consult = mysqli_fetch_assoc($result);
    if ($user_pass == $consult['contrasenia']){
      $_SESSION['loggedin'] = true;
      $_SESSION['user_mail'] = $user_mail;
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + (5 * 60); //sesion de 5 minutos
      include("cerrar_conexion.php");

      header('location: /pantalla_principal.php');
    }
 }else{
   header('location: /index.php');
 }

 ?>

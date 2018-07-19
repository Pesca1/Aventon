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
      $_SESSION['user_name'] = $consult['nombre'];
      $_SESSION['user_surname'] = $consult['apellido'];
      $_SESSION['user_id'] = $consult['id_usuario'];
      $_SESSION['user_mail'] = $user_mail;
      $_SESSION['user_image'] = $consult['foto_perfil'];

      $_SESSION['loggedin'] = true;
      $_SESSION['start'] = time();
      $_SESSION['expire'] = $_SESSION['start'] + (60 * 60); //sesion de 5 minutos
      $_SESSION['user_id'] = $consult['id_usuario'];

      header('location: /vistas/ver_perfil.php');
    }
  } else {
   header('location: /index.php?login_error');
  }
  include("cerrar_conexion.php");
 ?>

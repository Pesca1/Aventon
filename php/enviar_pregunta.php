<?php
  include("verficar_sesion.php");
  include("abrir_conexion.php");
  include("utils.php");

  $trip_id = $_POST['trip_id'];
  $question = $_POST['question'];
  $user_id = $_SESSION['user_id'];

  $query = "INSERT INTO pregunta (id_usuario, id_viaje, texto) VALUES ('$user_id', '$trip_id', '$question')";
  $result = mysqli_query($conn, $query);
  
  if(!$result){
    header("Location: /vistas/ver_detalles_viaje.php?db_error&trip_id=$trip_id");
  }else{
    $query = "SELECT * FROM viajes WHERE id_viaje='$trip_id'";
    $result = mysqli_query($conn, $query);
    $trip = mysqli_fetch_assoc($result);

    $query2 = "SELECT * FROM usuario WHERE id_usuario=".$trip["id_usuario"];
    $driver = mysqli_fetch_assoc(mysqli_query($conn, $query2));
    $driver_email = $driver["mail"];
    $mail = "Hola! \n Te avisamos que ".$_SESSION['user_name']." ".$_SESSION['user_surname']." acaba de publicar un comentario en tu viaje de ".$trip['origen']." a ".$trip['destino']." el ".formatDate($trip['fecha_hora'])." hs.\n Pudes entrar a la aplicación para responder \n Saludos, equipo de Aventon ";
    mail($driver_email, "Te han hecho una pregunta", $mail);
    header("Location: /vistas/ver_detalles_viaje.php?trip_id=$trip_id");
  }

  include("cerrar_conexion.php");
?>
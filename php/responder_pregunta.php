<?php
  include("verficar_sesion.php");
  include("abrir_conexion.php");
  include("utils.php");

  $question_id = $_POST["question_id"];
  $answer = $_POST["answer"];
  $trip_id = $_POST["trip_id"];

  $query = "UPDATE pregunta SET respuesta='$answer' WHERE id_pregunta='$question_id'";
  $result = mysqli_query($conn, $query);
  if ($result){
    $query = "SELECT * FROM pregunta WHERE id_pregunta='$question_id'";
    $result = mysqli_query($conn, $query);
    $question = mysqli_fetch_assoc($result);

    $query = "SELECT * FROM viajes WHERE id_viaje='$trip_id'";
    $result = mysqli_query($conn, $query);
    $trip = mysqli_fetch_assoc($result);

    $query2 = "SELECT * FROM usuario WHERE id_usuario=".$question['id_usuario'];
    $user = mysqli_fetch_assoc(mysqli_query($conn, $query2));
    $user_email = $user["mail"];
    $mail = "Hola! \n Te avisamos que ".$_SESSION['user_name']." ".$_SESSION['user_surname']." acaba de responder tu comentario que hiciste en la publicación del viaje de ".$trip['origen']." a ".$trip['destino']." el ".formatDate($trip['fecha_hora'])." hs.\n Pudes entrar a la aplicación para ver la respuesta \n Saludos, equipo de Aventon ";
    mail($user_email, "Te han respondido una pregunta", $mail);
    header("Location: /vistas/ver_viaje.php?id=$trip_id");
  }else{
    header("Location: /vistas/ver_viaje.php?db_error&id=$trip_id");
  }

  include("cerrar_conexion.php");
?>

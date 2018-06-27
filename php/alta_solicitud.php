<?php
  include("verficar_sesion.php");
  include("abrir_conexion.php");
  include("utils.php");
  
  $card_number = $_POST["card"];
  $commentary = $_POST["commentary"];
  $trip_id = $_POST["trip_id"];
  $user_id = $_SESSION["user_id"];

  $query = "SELECT * FROM tarjetas WHERE numero='$card_number'";
  $result = mysqli_query($conn, $query);
  $card = mysqli_fetch_assoc($result);
  
  $query = "SELECT * FROM viajes WHERE id_viaje='$trip_id'";
  $result = mysqli_query($conn, $query);
  $trip = mysqli_fetch_assoc($result);

  if ($card["vencimiento"] < $trip["fecha_hora"]){
    header("Location: /vistas/solicitud_solicitar_asiento.php?card_expirated");
    exit;
  }
  
  $query = "INSERT INTO solicitud (id_pasajero, id_viaje, estado, comentario) VALUES ('$user_id', '$trip_id', 0, '$commentary')";
  $result = mysqli_query($conn, $query);

  if($result){
    $query = "SELECT * FROM usuario WHERE id_usuario=".$trip["id_usuario"];
    $driver = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $driver_email = $driver["mail"];
    $mail = "Hola! \n Te avisamos que ".$_SESSION['user_name']." ".$_SESSION['user_surname']." quiere participar de tu viaje de ".$trip['origen']." a ".$trip['destino']." el ".formatDate($trip['fecha_hora'])." hs.\n Saludos!\n Equipo de Aventon ";
    mail($driver_email, "Nueva solicitud de viaje", $mail);
    header("Location: /vistas/listar_todos_los_viajes.php?sol_success");
  } else {
    header("Location: /vistas/ver_viajes.php?db_error");
  }

  include("cerrar_conexion.php");
?>

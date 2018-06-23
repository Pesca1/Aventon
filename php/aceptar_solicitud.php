<?php
  include("verficar_sesion.php");
  include("abrir_conexion.php");
  include("utils.php");

  $request_id = $_POST["request_id"];
  
  $query = "SELECT * FROM solicitud WHERE id_solicitud='$request_id'";
  $result = mysqli_query($conn, $query);
  $request = mysqli_fetch_assoc($result);

  $query = "SELECT * FROM viajes WHERE id_viaje='".$request['id_viaje']."'";
  $result = mysqli_query($conn, $query);
  $trip = mysqli_fetch_assoc($result);

  if(availableSeats($conn, $trip["id_viaje"]) <= 0){
    header("Location: /vistas/ver_solicitudes.php?no_seats");
    exit();
  }else{
    $query = "UPDATE solicitud SET estado ='".ACCEPTED."' WHERE id_solicitud='$request_id'";
    mysqli_query($conn, $query);
    
    $query = "SELECT * FROM usuario WHERE id_usuario='".$request['id_pasajero']."'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    $user_mail = $user["mail"];
    $sent = mail("$user_mail", "¡Su solicitud ha sido aceptada! Aventon", "Hola! Nos comunicamos para informarte que tu solicitud para el viaje: \n ".$trip['origen']." con destino a ".$trip['destino']." \n fue aceptado, esperamos que disfrutes de este viaje. \n Equipo de Aventon ");
		if(!$sent){
      header("Location: /vistas/ver_solicitudes.php?notification_error");
    }
    header ("Location: /vistas/ver_solicitudes.php?success_accepted");
    include("php/cerrar_conexion.php");
  }

?>
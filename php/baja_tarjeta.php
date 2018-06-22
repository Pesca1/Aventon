<?php
  include("verficar_sesion.php");
  include("abrir_conexion.php");
  include("utils.php");
  $card=$_POST['card_number'];

  $query = "SELECT * FROM viajes WHERE tarjeta=$card";
  $result = mysqli_query($conn, $query);
  while($trip = mysqli_fetch_assoc($result)){
    if(isPendingTrip($trip)){
      header("Location: /vistas/ver_tarjetas.php?pending_trip");
      exit();
    }
  }

  $query = "SELECT * FROM solicitud WHERE numero_tarjeta=$card";
  $result = mysqli_query($conn, $query);
  while($request = mysqli_fetch_assoc($result)){
    $query = "SELECT * FROM viajes WHERE id_viaje='".$request["id_viaje"]."'";
    $trip = mysqli_fetch_assoc(mysqli_query($conn, $query));
    echo "Viaje de ".$trip["origen"]." a ".$trip["destino"];
    if(isPendingTrip($trip)){
      header("Location: /vistas/ver_tarjetas.php?pending_request");
      exit();
    }
  }

  $query = "DELETE FROM tarjetas WHERE numero='$card'";
  $result = mysqli_query($conn, $query);
  if($result){
    header("Location: /vistas/ver_tarjetas.php?deleted_success");
  } else {
    header("Location: /vistas/ver_tarjetas.php?deleted_error");
  }
  include("php/cerrar_conexion.php");
?>

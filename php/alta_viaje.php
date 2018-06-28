<?php
  include("verficar_sesion.php");
  include("abrir_conexion.php");
  include("utils.php");


  $plate = $_POST["car_plate"];
  $origin = trim($_POST["origin"]);
  $destination = trim($_POST["destination"]);
  $duration = intval(trim($_POST["duration_hours"]))+(intval(trim($_POST["duration_minutes"]))/60);
  $date = "2018-" . $_POST["month"] ."-". $_POST["day"];
  $time = $_POST["time"].":00";
  $datetime = $date ." ".$time;
  $price = trim($_POST["price"]);
  $card = $_POST["card"];
  $desc = $_POST["description"];
  $user_id = $_SESSION["user_id"];
  
  if(isExpiredCard($conn, $card, $date)){
    header("Location: /vistas/ver_viajes.php?expired_card");
    exit();
  }

  $query = "SELECT * FROM viajes WHERE id_usuario='$user_id'";
  $result = mysqli_query($conn, $query);
  if($result){
    while($trip = mysqli_fetch_assoc($result)){
      if(!checkTripDates($datetime, $duration, $trip["fecha_hora"], $trip["duracion"])){
        header("Location: /vistas/ver_viajes.php?date_error");
        exit;
      }
    }
  } else {
    header("Location: /vistas/ver_viajes.php?db_error");
  }
  
  $query = "SELECT * FROM solicitud WHERE id_pasajero='$user_id'";
  $result = mysqli_query($conn, $query);
  if($result){
    while($request = mysqli_fetch_assoc($result)){
      $query = "SELECT * FROM viajes WHERE id_viaje='".$request["id_viaje"]."'";
      $trip = mysqli_fetch_assoc(mysqli_query($conn, $query));
      echo "Viaje: "; print_r($trip);
      if(($request["estado"] != REJECTED) && !checkTripDates($datetime, $duration, $trip["fecha_hora"], $trip["duracion"])){
        header("Location: /vistas/ver_viajes.php?date_error");
        exit;
      }
    }
  } else {
    header("Location: /vistas/ver_viajes.php?db_error");
  }

  $query = "INSERT INTO viajes (id_usuario, patente, origen, destino, duracion, fecha_hora, descripcion, tipo, costo, tarjeta)
      VALUES ($user_id, '$plate', '$origin', '$destination', $duration, '$datetime', '$desc', 'Ocasional', $price, $card)";
  $result = mysqli_query($conn, $query);

  if($result){
    header("Location: /vistas/ver_viajes.php?reg_success");
  } else {
    header("Location: /vistas/ver_viajes.php?db_error");
  }

  include("cerrar_conexion.php");

?>

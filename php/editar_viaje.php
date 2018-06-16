<?php
  include("verficar_sesion.php");
  include("abrir_conexion.php");
  include("utils.php");

  $trip_id = $_POST["trip_id"];
  $plate = $_POST["car_plate"];
  $origin = trim($_POST["origin"]);
  $destination = trim($_POST["destination"]);
  $duration = trim($_POST["duration"]);
  $date = "2018-" . $_POST["month"] ."-". $_POST["day"];
  $time = $_POST["time"].":00";
  $datetime = $date ." ".$time;
  $type = $_POST["type"];
  var_dump($plate);
  $price = trim($_POST["price"]);
  $card = $_POST["card"];
  var_dump($card);
  $desc = $_POST["description"];
  $user_id = $_SESSION["user_id"];

  $query = "SELECT * FROM viajes WHERE id_usuario='$user_id' AND NOT id_viaje='$trip_id'";
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
      if(!checkTripDates($datetime, $duration, $trip["fecha_hora"], $trip["duracion"])){
        // header("Location: /vistas/ver_viajes.php?date_error");
        exit;
      }
    }
  } else {
    // header("Location: /vistas/ver_viajes.php?db_error");
  }

  $query = "UPDATE viajes SET patente='$plate', origen='$origin', destino='$destination', duracion='$duration', fecha_hora='$datetime', descripcion='$desc', tipo='$type', costo='$price', tarjeta='$card' WHERE id_viaje='$trip_id'";
  $result = mysqli_query($conn, $query);

  if($result){
    // header("Location: /vistas/ver_viajes.php?reg_success");
  } else {
    // header("Location: /vistas/ver_viajes.php?db_error");
  }

  include("cerrar_conexion.php");  

?>
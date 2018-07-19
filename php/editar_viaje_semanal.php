<?php
  include("verficar_sesion.php");
  include("abrir_conexion.php");
  include("utils.php");

  $trip_id = $_POST["trip_id"];
  $plate = $_POST["car_plate"];
  $origin = trim($_POST["origin"]);
  $destination = trim($_POST["destination"]);
  $duration = intval(trim($_POST["duration_hours"]))+(intval(trim($_POST["duration_minutes"]))/60);
  $time = $_POST["time"].":00";
  $price = trim($_POST["price"]);
  $card = $_POST["card"];
  $desc = $_POST["description"];
  $user_id = $_SESSION["user_id"];
  $days = array(
    1 => isset($_POST["monday"]),
    2 => isset($_POST["tuesday"]),
    3 => isset($_POST["wednesday"]),
    4 => isset($_POST["thursday"]),
    5 => isset($_POST["friday"]),
    6 => isset($_POST["saturday"]),
    7 => isset($_POST["sunday"])
  );
  $weeks = $_POST["weeks"];


  $query = "DELETE FROM viaje_semanal WHERE id_viaje='$trip_id'";
  $result = mysqli_query($conn, $query);

  if(!$result){
    header("Location: /vistas/ver_viajes.php?db_error");
    exit();
  }

  $otherTrips = array();

  $query = "SELECT * FROM viajes WHERE id_usuario='$user_id'";
  $result = mysqli_query($conn, $query);
  if($result){
    while($trip = mysqli_fetch_assoc($result)){
      if($trip["tipo"] == ONE_TIME_TRIP){
        array_push($otherTrips, $trip);
      } else {
        $query = "SELECT * FROM viaje_semanal WHERE id_viaje=".$trip["id_viaje"];
        $actualTrips = mysqli_query($conn, $query);
        while($actualTrip = mysqli_fetch_assoc($actualTrips)){
          $actualTrip["origen"]= $trip["origen"];
          $actualTrip["destino"]=$trip["destino"];
          $actualTrip["duracion"]=$trip["duracion"];
          array_push($otherTrips, $actualTrip);
        }
      }
    }
  } else {
    header("Location: /vistas/ver_viajes.php?db_error");
  }

  $query = "SELECT * FROM solicitud WHERE id_pasajero='$user_id' AND estado!=".REJECTED;
  $result = mysqli_query($conn, $query);
  if($result){
    while($request = mysqli_fetch_assoc($result)){
      $query = "SELECT * FROM viajes WHERE id_viaje='".$request["id_viaje"]."'";
      $trip = mysqli_fetch_assoc(mysqli_query($conn, $query));
      array_push($otherTrips, $trip);
    }
  } else {
    header("Location: /vistas/ver_viajes.php?db_error");
  }

  $tripDates = createWeeklyTrips($days, $time, $weeks);
  
  if (empty($tripDates)){
    header("Location: /vistas/ver_viajes.php?date_trip_error");
  }
  foreach($tripDates as $tripDate){
    // echo $tripDate."<br>";
    if(isExpiredCardCommonDate($conn, $card, $tripDate)){
      header("Location: /vistas/ver_viajes.php?expired_card");
      exit();
    }
    foreach($otherTrips as $trip){
      if(!checkTripDates($tripDate, $duration, $trip["fecha_hora"], $trip["duracion"])){
        header("Location: /vistas/ver_viajes.php?date_error");
        exit();
      }
    }
  }

  $query = "UPDATE viajes SET id_usuario='$user_id',  patente='$plate', 
                              origen='$origin',       destino='$destination',
                              duracion='$duration',   fecha_hora= '".$tripDates[0]."',
                              descripcion='$desc',    tipo='".WEEKLY_TRIP."',
                              costo='$price',         tarjeta='$card',
                              semanas='$weeks' WHERE id_viaje='$trip_id'";
  $result = mysqli_query($conn, $query);

  if(!$result){
    header("Location: /vistas/ver_viajes.php?db_error");
    exit();
  }

  foreach($tripDates as $tripDate){
    $query = "INSERT INTO viaje_semanal (id_viaje, fecha_hora) VALUES ($trip_id, '$tripDate')";
    $result= mysqli_query($conn, $query);
    if(!$result){
      header("Location: /vistas/ver_viajes.php?db_error");
      exit();
    }
  }

  header("Location: /vistas/ver_viajes.php?edit_success");


  include("cerrar_conexion.php");  
?>
<?php
  include("verficar_sesion.php");
  include("abrir_conexion.php");
  include("utils.php");
  $user_id = $_SESSION["user_id"];
  $trip_id = $_POST["trip_id"];

  if(dbOcurrences($conn, "SELECT * FROM tarjetas WHERE id_usuario='".$user_id."'") == 0){
    header("Location: /vistas/listar_todos_los_viajes.php?no_card");
    exit();
  } else if(hasOldCalifications($conn, $_SESSION["user_id"])) {
    header("Location: /vistas/listar_todos_los_viajes.php?pending_califications");
    exit();
  }else if(dbOcurrences($conn, "SELECT * FROM solicitud WHERE id_pasajero='$user_id' AND id_viaje='$trip_id'") > 0){
    header("Location: /vistas/listar_todos_los_viajes.php?has_one");
    exit();
  }

  $query = "SELECT * FROM viajes WHERE id_viaje='$trip_id'";
  $result = mysqli_query($conn, $query);
  $current_trip = mysqli_fetch_assoc($result);
  $datetime = $current_trip["fecha_hora"];
  $duration = $current_trip["duracion"];

  $query = "SELECT * FROM viajes WHERE id_usuario='$user_id'";
  $result = mysqli_query($conn, $query);
  if($result){
    while($trip = mysqli_fetch_assoc($result)){
      if(!checkTripDates($datetime, $duration, $trip["fecha_hora"], $trip["duracion"])){
        header("Location: /vistas/listar_todos_los_viajes.php?date_error");
        exit;
      }
    }
  } else {
    header("Location: /vistas/listar_todos_los_viajes.php?db_error");
  }

  $query = "SELECT * FROM solicitud WHERE id_pasajero='$user_id'";
  $result = mysqli_query($conn, $query);
  if($result){
    while($request = mysqli_fetch_assoc($result)){
      $query = "SELECT * FROM viajes WHERE id_viaje='".$request["id_viaje"]."'";
      $trip = mysqli_fetch_assoc(mysqli_query($conn, $query));
      echo "Viaje: "; print_r($trip);
      if(!checkTripDates($datetime, $duration, $trip["fecha_hora"], $trip["duracion"])){
        header("Location: /vistas/listar_todos_los_viajes.php?date_error");
        exit;
      }
    }
  } else {
    header("Location: /vistas/listar_todos_los_viajes.php?db_error");
  }

  header("Location: /vistas/solicitud_solicitar_asiento.php?trip_id=".$_POST["trip_id"]);


  include("cerrar_conexion.php");
?>
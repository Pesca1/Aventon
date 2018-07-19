<?php
  include("abrir_conexion.php");
  include("utils.php");

  $query = "SELECT * FROM viajes WHERE pago_pasajero=".UNPAID_TRIP." AND tipo=".ONE_TIME_TRIP;
  $trips = mysqli_query($conn, $query);
  while($trip = mysqli_fetch_assoc($trips)){
    if(!isPendingTrip($conn, $trip)){
      $query = "SELECT * FROM solicitud WHERE estado=".ACCEPTED." AND id_viaje=".$trip["id_viaje"];
      $requests = mysqli_query($conn, $query);
      while($request = mysqli_fetch_assoc($requests)){
        $query = "SELECT * FROM usuario WHERE id_usuario=".$request["id_pasajero"];
        $user = mysqli_fetch_assoc(mysqli_query($conn, $query));
        $text = "Hola ".$user["nombre"]."!\nTe informamos que se debitó el costo del viaje de ".$trip["origen"]." a ".$trip["destino"].", $".formatPrice($trip["costo"]).", de tu tarjeta ".formatCard($request["numero_tarjeta"]).".\nTe deseamos un buen viaje!\nEquipo de Aventón";
        mail($user["mail"], "Buen viaje!", $text);

        $query = "INSERT INTO transaccion (id_usuario, id_viaje, monto, tipo, fecha_hora) VALUES (".$user["id_usuario"].",".$trip["id_viaje"].",".$trip["costo"].",".PASSENGER.", '".$trip["fecha_hora"]."')";
        mysqli_query($conn, $query);
        $transactionId = mysqli_fetch_array(mysqli_query($conn, "SELECT LAST_INSERT_ID();"))[0];
        $query = "INSERT INTO notificacion (id_usuario, id_transaccion, tipo) VALUES (".$user["id_usuario"].", $transactionId, ".PASSENGER.")";
        mysqli_query($conn, $query);
        $query = "UPDATE viajes SET pago_pasajero=".PAID_TRIP." WHERE id_viaje=".$trip["id_viaje"];
        mysqli_query($conn, $query);
      }
    }
  }

  $query = "SELECT * FROM viajes WHERE tipo=".WEEKLY_TRIP;
  $weeklyTrips = mysqli_query($conn, $query);
  while($weeklyTrip = mysqli_fetch_assoc($weeklyTrips)){
    $query = "SELECT * FROM viaje_semanal WHERE id_viaje=".$weeklyTrip["id_viaje"]." AND pago_pasajero=".UNPAID_TRIP;
    $trips = mysqli_query($conn, $query);
    while($trip = mysqli_fetch_assoc($trips)){
      if(!isPendingTrip($conn, $trip)){        
        $query = "SELECT * FROM solicitud WHERE estado=".ACCEPTED." AND id_viaje=".$trip["id_viaje"];
        $requests = mysqli_query($conn, $query);
        while($request = mysqli_fetch_assoc($requests)){
          $query = "SELECT * FROM usuario WHERE id_usuario=".$request["id_pasajero"];
          $user = mysqli_fetch_assoc(mysqli_query($conn, $query));
          $text = "Hola ".$user["nombre"]."!\nTe informamos que se debitó el costo del viaje de ".$weeklyTrip["origen"]." a ".$weeklyTrip["destino"].", $".formatPrice($weeklyTrip["costo"]).", de tu tarjeta ".formatCard($request["numero_tarjeta"]).".\nTe deseamos un buen viaje!\nEquipo de Aventón";
          mail($user["mail"], "Buen viaje!", $text);
          $query = "INSERT INTO transaccion (id_usuario, id_viaje, monto, tipo, fecha_hora) VALUES (".$user["id_usuario"].",".$weeklyTrip["id_viaje"].",".$weeklyTrip["costo"].",".PASSENGER.", '".$trip["fecha_hora"]."')";
          mysqli_query($conn, $query); 
          $transactionId = mysqli_fetch_array(mysqli_query($conn, "SELECT LAST_INSERT_ID();"))[0];
          $query = "INSERT INTO notificacion (id_usuario, id_transaccion, tipo) VALUES (".$user["id_usuario"].", $transactionId, ".PASSENGER.")";
          mysqli_query($conn, $query);
          $query = "UPDATE viaje_semanal SET pago_pasajero=".PAID_TRIP." WHERE id_viaje_semanal=".$trip["id_viaje_semanal"];
          mysqli_query($conn, $query);
        }
      }
    }
  }

  $query = "SELECT * FROM viajes WHERE tipo=".ONE_TIME_TRIP." AND pago_pasajero=".PAID_TRIP." AND pago_conductor=".UNPAID_TRIP;
  $trips = mysqli_query($conn, $query);
  while($trip = mysqli_fetch_assoc($trips)){
    if(isFinishedTrip($trip["fecha_hora"], $trip["duracion"])){
      $query = "SELECT * FROM usuario WHERE id_usuario=".$trip["id_usuario"];
      $driver = mysqli_fetch_assoc(mysqli_query($conn, $query));
      $query = "SELECT COUNT(*) FROM solicitud WHERE id_viaje=".$trip["id_viaje"]." AND estado=".ACCEPTED;
      $requests = mysqli_fetch_array(mysqli_query($conn, $query))[0];
      $cash = $requests * $trip["costo"];
      $driverCash = $cash/100*95;
      $text = "Hola ".$driver["nombre"]."!\nTe informamos que se te depositó lo recaudado del viaje de ".$trip["origen"]." a ".$trip["destino"].", $".formatPrice($driverCash).", en tu tarjeta ".formatCard($trip["tarjeta"]).". Se ha descontado una comisión del 5% para Aventón.\nEsperamos que hayas tenido un buen viaje, no olvides calificar a los pasajeros para poder seguir viajando y ahorrando con Aventón. Saludos!\nEquipo de Aventón";
      mail($driver["mail"], "Deposito de viaje", $text);
      $query = "INSERT INTO transaccion (id_usuario, id_viaje, monto, tipo, fecha_hora) VALUES (".$driver["id_usuario"].",".$trip["id_viaje"].",".$driverCash.",".DRIVER.", '".finishTime($trip["fecha_hora"], $trip["duracion"])."')";
      mysqli_query($conn, $query); 
      $transactionId = mysqli_fetch_array(mysqli_query($conn, "SELECT LAST_INSERT_ID();"))[0];
      $query = "INSERT INTO notificacion (id_usuario, id_transaccion, tipo) VALUES (".$driver["id_usuario"].", $transactionId, ".DRIVER.")";
      mysqli_query($conn, $query);
      $query = "UPDATE viajes SET pago_conductor=".PAID_TRIP." WHERE id_viaje=".$trip["id_viaje"];
      mysqli_query($conn, $query);

      // CREAR CALIFICACIONES
      $query = "SELECT * FROM solicitud WHERE id_viaje=".$trip["id_viaje"]." AND estado=".ACCEPTED;
      $requests = mysqli_query($conn, $query);
      while($request = mysqli_fetch_assoc($requests)){
        $query = "INSERT INTO puntua_conductor (id_pasajero, id_conductor, id_viaje, fecha) VALUES (".$request["id_pasajero"].", ".$driver["id_usuario"].", ".$trip["id_viaje"].", '".$trip["fecha_hora"]."')";
        mysqli_query($conn, $query);
        $query = "INSERT INTO notificacion (id_usuario, tipo) VALUES (".$request["id_pasajero"].", ".CALIFICATION_PASSENGER.")";
        mysqli_query($conn, $query);

        $query = "INSERT INTO puntua_pasajero (id_pasajero, id_conductor, id_viaje, fecha) VALUES (".$request["id_pasajero"].", ".$driver["id_usuario"].", ".$trip["id_viaje"].", '".$trip["fecha_hora"]."')";
        mysqli_query($conn, $query);
        $query = "INSERT INTO notificacion (id_usuario, tipo) VALUES (".$driver["id_usuario"].", ".CALIFICATION_DRIVER.")";
        mysqli_query($conn, $query);
      }
    }
  }

  $query = "SELECT * FROM viaje_semanal WHERE pago_pasajero=".PAID_TRIP." AND pago_conductor=".UNPAID_TRIP;
  $trips = mysqli_query($conn, $query);
  while($trip = mysqli_fetch_assoc($trips)){
    $query = "SELECT * FROM viajes WHERE id_viaje=".$trip["id_viaje"];
    $weeklyTrip = mysqli_fetch_assoc(mysqli_query($conn, $query));
    if(isFinishedTrip($trip["fecha_hora"], $weeklyTrip["duracion"])){
      $query = "SELECT * FROM usuario WHERE id_usuario=".$weeklyTrip["id_usuario"];
      $driver = mysqli_fetch_assoc(mysqli_query($conn, $query));
      $query = "SELECT COUNT(*) FROM solicitud WHERE id_viaje=".$weeklyTrip["id_viaje"]." AND estado=".ACCEPTED;
      $requests = mysqli_fetch_array(mysqli_query($conn, $query))[0];
      $cash = $requests * $weeklyTrip["costo"];
      $driverCash = $cash/100*95;
      $text = "Hola ".$driver["nombre"]."!\nTe informamos que se te depositó lo recaudado del viaje de ".$weeklyTrip["origen"]." a ".$weeklyTrip["destino"].", $".formatPrice($driverCash).", en tu tarjeta ".formatCard($weeklyTrip["tarjeta"]).". Se ha descontado una comisión del 5% para Aventón.\nEsperamos que hayas tenido un buen viaje, no olvides calificar a los pasajeros para poder seguir viajando y ahorrando con Aventón. Saludos!\nEquipo de Aventón";
      mail($driver["mail"], "Deposito de viaje", $text);
      $query = "INSERT INTO transaccion (id_usuario, id_viaje, monto, tipo, fecha_hora) VALUES (".$driver["id_usuario"].",".$weeklyTrip["id_viaje"].",".$driverCash.",".DRIVER.", '".finishTime($trip["fecha_hora"], $weeklyTrip["duracion"])."')";
      mysqli_query($conn, $query); 
      $transactionId = mysqli_fetch_array(mysqli_query($conn, "SELECT LAST_INSERT_ID();"))[0];
      $query = "INSERT INTO notificacion (id_usuario, id_transaccion, tipo) VALUES (".$driver["id_usuario"].", $transactionId, ".DRIVER.")";
      mysqli_query($conn, $query);
      $query = "UPDATE viaje_semanal SET pago_conductor=".PAID_TRIP." WHERE id_viaje_semanal=".$trip["id_viaje_semanal"];
      mysqli_query($conn, $query);
      
      // CREAR CALIFICACIONES
      $query = "SELECT * FROM solicitud WHERE id_viaje=".$weeklyTrip["id_viaje"]." AND estado=".ACCEPTED;
      $requests = mysqli_query($conn, $query);
      while($request = mysqli_fetch_assoc($requests)){
        $query = "INSERT INTO puntua_conductor (id_pasajero, id_conductor, id_viaje, fecha) VALUES (".$request["id_pasajero"].", ".$driver["id_usuario"].", ".$weeklyTrip["id_viaje"].", '".$trip["fecha_hora"]."')";
        mysqli_query($conn, $query);
        $query = "INSERT INTO notificacion (id_usuario, tipo) VALUES (".$request["id_pasajero"].", ".CALIFICATION_PASSENGER.")";
        mysqli_query($conn, $query);

        $query = "INSERT INTO puntua_pasajero (id_pasajero, id_conductor, id_viaje, fecha) VALUES (".$request["id_pasajero"].", ".$driver["id_usuario"].", ".$weeklyTrip["id_viaje"].", '".$trip["fecha_hora"]."')";
        mysqli_query($conn, $query);
        $query = "INSERT INTO notificacion (id_usuario, tipo) VALUES (".$driver["id_usuario"].", ".CALIFICATION_DRIVER.")";
        mysqli_query($conn, $query);
      }
    }
  }


  include("cerrar_conexion.php");
?>

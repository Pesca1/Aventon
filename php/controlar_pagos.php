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
        $text = "Hola ".$user["nombre"]."!\nTe informamos que se debitó el costo del viaje de ".$trip["origen"]." a ".$trip["destino"].", $".formatPrice($trip["costo"]).", de tu tarjeta ".formatCard($trip["tarjeta"]).".\nTe deseamos un buen viaje!\nEquipo de Aventón";
        mail($user["mail"], "Buen viaje!", $text);

        $query = "INSERT INTO transaccion (id_usuario, id_viaje, monto, tipo) VALUES (".$user["id_usuario"].",".$trip["id_viaje"].",".$trip["costo"].",".PASSENGER.")";
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
          $text = "Hola ".$user["nombre"]."!\nTe informamos que se debitó el costo del viaje de ".$weeklyTrip["origen"]." a ".$weeklyTrip["destino"].", $".formatPrice($weeklyTrip["costo"]).", de tu tarjeta ".formatCard($weeklyTrip["tarjeta"]).".\nTe deseamos un buen viaje!\nEquipo de Aventón";
          mail($user["mail"], "Buen viaje!", $text);
          $query = "INSERT INTO transaccion (id_usuario, id_viaje, monto, tipo, fecha_hora) VALUES (".$user["id_usuario"].",".$weeklyTrip["id_viaje"].",".$weeklyTrip["costo"].",".PASSENGER.", '".$trip["fecha_hora"]."')";
          mysqli_query($conn, $query);
          $query = "UPDATE viaje_semanal SET pago_pasajero=".PAID_TRIP." WHERE id_viaje_semanal=".$trip["id_viaje_semanal"];
          mysqli_query($conn, $query);
        }
      }
    }
  }


  include("cerrar_conexion.php");
?>

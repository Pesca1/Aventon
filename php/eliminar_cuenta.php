<?php 
  include("abrir_conexion.php");
  include("utils.php");
  
  $user_id = $_GET["id"];
  $query = "SELECT * FROM usuario WHERE id_usuario=".$user_id;
  $user = mysqli_fetch_assoc(mysqli_query($conn, $query));

  $query = "SELECT * FROM viajes WHERE id_usuario=$user_id";
  $trips = mysqli_query($conn, $query);
  while($trip = mysqli_fetch_assoc($trips)){
    if(isPendingTrip($conn, $trip)){
      $query = "SELECT * FROM solicitud WHERE id_viaje=".$trip["id_viaje"]." AND estado=".ACCEPTED;
      $requests = mysqli_query($conn, $query);
      while($request = mysqli_fetch_assoc($requests)){
        $query = "SELECT * FROM usuario WHERE id_usuario=".$request["id_pasajero"];
        $pass = mysqli_fetch_assoc(mysqli_query($conn, $query));
        if($trip["tipo"] == ONE_TIME_TRIP){
          $text = "Hola ".$pass["nombre"]."!\n Te informamos que el viaje de ".$trip["origen"]." a ".$trip["destino"]." para el ".formatDate($trip["fecha_hora"])." en el que ibas a viajar fue cancelado, esperamos que esto no sea una molestia.\n Saludos! El equipo de Aventón";
        } else {
          $text = "Hola ".$pass["nombre"]."!\n Te informamos que el viaje de ".$trip["origen"]." a ".$trip["destino"]." para los días ";
          $query = "SELECT * FROM viaje_semanal WHERE id_viaje='".$trip["id_viaje"]."'";
          $result = mysqli_query($conn, $query);
          $daysToTrip = daysOfTrips($result);
          for($i = 1; $i < 8; $i++){
            if(in_array($i, $daysToTrip)){
              $text .= $days[$i];
              $text .= ", ";
            }
          }
          $text .= "en el que ibas a viajar fue cancelado, esperamos que esto no sea una molestia.\n Saludos! El equipo de Aventón";
        }
        mail($pass["mail"], "Viaje cancelado",$text);
      }
      $query = "UPDATE viajes SET pago_conductor=".PAID_TRIP.", pago_pasajero=".PAID_TRIP." WHERE id_viaje=".$trip["id_viaje"];
      mysqli_query($conn, $query);
      echo $query."<br>";
      $query = "UPDATE viaje_semanal SET pago_conductor=".PAID_TRIP.", pago_pasajero=".PAID_TRIP." WHERE id_viaje=".$trip["id_viaje"];
      mysqli_query($conn, $query);
      echo $query."<br>";
    }
  }

  $query = "SELECT * FROM solicitud WHERE id_pasajero=".$user_id." AND estado=".ACCEPTED;
  $requests = mysqli_query($conn, $query);
  while($request = mysqli_fetch_assoc($requests)){
    $query = "SELECT * FROM viajes WHERE id_viaje=".$request["id_viaje"];
    $trip = mysqli_fetch_assoc(mysqli_query($conn, $query));
    if(isPendingTrip($conn, $trip)){
      $query = "SELECT * FROM usuario WHERE id_usuario=".$trip["id_usuario"];
      $driver = mysqli_fetch_assoc(mysqli_query($conn, $query));
      if($trip["tipo"] == ONE_TIME_TRIP){
      $text = "Hola ".$driver["nombre"]."!\n Te informamos que ".$user["nombre"]." ".$user["apellido"]." no va a partircipar de tu viaje de ".$trip["origen"]." a ".$trip["destino"]." para el ".formatDate($trip["fecha_hora"]).", por lo que hay un asiento libre para otro pasajero. No olvides ver las solicitudes para este viaje y asi poder ahorrar mas en el.\n Saludos! El equipo de Aventon";
      } else {
        $text = "Hola ".$driver["nombre"]."!\n Te informamos que ".$user["nombre"]." ".$user["apellido"]." no va a partircipar de tu viaje de ".$trip["origen"]." a ".$trip["destino"]." para los días ";
        $query = "SELECT * FROM viaje_semanal WHERE id_viaje='".$trip["id_viaje"]."'";
        $result = mysqli_query($conn, $query);
        $daysToTrip = daysOfTrips($result);
        for($i = 1; $i < 8; $i++){
          if(in_array($i, $daysToTrip)){
            $text .= $days[$i];
            $text .= ", ";
          }
        }
        $text .= ", por lo que hay un asiento libre para otro pasajero. No olvides ver las solicitudes para este viaje y asi poder ahorrar mas en el.\n Saludos! El equipo de Aventon";
      }
      mail($driver["mail"], "Asiento libre",$text);

      $query = "DELETE FROM solicitud WHERE id_solicitud=".$request["id_solicitud"];
      mysqli_query($conn, $query);
      echo $query."<br>";
    }
  }
  
  $query = "SELECT * FROM vehiculo WHERE id_usuario=".$user_id;
  $cars = mysqli_query($conn, $query);
  while($car = mysqli_fetch_assoc($cars)){
    $query = "SELECT * FROM fotos_vehiculo WHERE patente='".$car["patente"]."'";
    $pics = mysqli_query($conn, $query);
    $path = "../img/vehicles/";
    while($pic = mysqli_fetch_assoc($pics)){
      unlink($path.$pic["foto"]);
      echo "Borrar ".$path.$pic["foto"]."<br>";
      $query = "DELETE FROM fotos_vehiculo WHERE foto='".$pic["foto"]."'";
      echo $query."<br>";
      mysqli_query($conn, $query);
    }
    $query = "DELETE FROM vehiculo WHERE patente='".$car["patente"]."'";
    echo $query."<br>";
    mysqli_query($conn, $query);
  }

  $query = "DELETE FROM tarjetas WHERE id_usuario=".$user_id;
  mysqli_query($conn, $query);
  echo $query."<br>";

  $query = "DELETE FROM puntua_conductor WHERE id_conductor=".$user["id_usuario"]." AND estado=".PENDING;
  mysqli_query($conn, $query);
  echo $query."<br>";
  $query = "DELETE FROM puntua_pasajero WHERE id_pasajero=".$user["id_usuario"]." AND estado=".PENDING;
  mysqli_query($conn, $query);
  echo $query."<br>";

  $query = "UPDATE usuario SET mail='0' WHERE id_usuario=".$user_id;
  mysqli_query($conn, $query);
      echo $query."<br>";

  include("cerrar_conexion.php");
  session_start();
  unset($_SESSION['user_mail']);
  session_destroy();
  header('location: /index.php?deleted_account');
?>

<?php
  include_once("constants.php");

  function show_error($string){
    echo "<script>show_error('$string');</script>";
  }

  function show_success($string){
    echo "<script>show_success('$string');</script>";
  }

  function get_success($get, $string){
    if(isset($_GET[$get])){
      show_success($string);
    }
  }

  function get_error($get, $string){
    if(isset($_GET[$get])){
      show_error($string);
    }
  }

  function printTime($time){ 
    $hours = floor($time);
    $minutes = $time-$hours;
    if($hours > 0){
      echo $hours.(($hours>=2)?" horas":" hora");
      if($minutes > 0){
        echo " y";
      }
    }
    if($minutes > 0){
      echo " ".($minutes*60)." minutos";
    }
  }

  function dbOcurrences($conn, $query){
    $result = mysqli_query($conn, $query);
    if($result){
      return mysqli_num_rows($result);
    } else {
      echo "<br>Hubo un error al conectarse con la base de datos";
      return -1;
    }
  }

  function hasOldCalifications($conn, $id){ 
    $today = new DateTime("now");
    $query = "SELECT * FROM puntua_pasajero WHERE id_conductor='".$id."' AND estado=".PENDING;
    $result = mysqli_query($conn, $query);
    if($result){
      while($cal = mysqli_fetch_assoc($result)){
        $date = new DateTime($cal["fecha"]);
//        if($today->diff($date)->m >= 1){
          if($today > $date){   
        return true;
        }
      }
    }
    $query = "SELECT * FROM puntua_conductor WHERE id_pasajero='".$id."' AND estado=".PENDING;
    $result = mysqli_query($conn, $query);
    if($result){
      while($cal = mysqli_fetch_assoc($result)){
        $date = new DateTime($cal["fecha"]);
//        if($today->diff($date)->m >= 1){
        if($today > $date){  
          return true;
        }
      }
    }
    return false;
  }

  function minutesFromHours($number){
    return ($number - floor($number))*60;
  }

  function addDate($date, $interval){
    $d = clone $date;
    $d->add($interval);
    return $d;
  }

  function dateToTime($date){
    return strtotime($date->format("d-m-Y H:i"));
  }

  function stringToInterval($string){
    return new DateInterval("PT".floor(intval($string))."H".floor(minutesFromHours($string))."M");
  }
  

  #Retorna true si las fecha NO se solapan
  function checkTripDates($dateString1, $interval1, $dateString2, $interval2){
    $startTime = DateTime::createFromFormat( "Y-m-d H:i:s", $dateString1);
    $chkStartTime = DateTime::createFromFormat("Y-m-d H:i:s", $dateString2);
    $interval1 = stringToInterval($interval1);
    $interval2 = stringToInterval($interval2);
    $endTime = addDate($startTime, $interval1);
    $chkEndTime = addDate($chkStartTime, $interval2);
   
    return (($chkEndTime < $startTime) || ($chkStartTime > $endTime));
  }

  ##retorna los asientos disponibles para un viaje
  function availableSeats($conn, $trip_id){
    $query = "SELECT * FROM viajes WHERE id_viaje='$trip_id'";
    
    $result = mysqli_query($conn, $query);
    $trip = mysqli_fetch_assoc($result);
    
    
    $query = "SELECT * FROM vehiculo WHERE patente='".$trip["patente"]."'";
    $result = mysqli_query($conn, $query);
    $vehicle = mysqli_fetch_assoc($result);
    $total_seats = $vehicle["asientos"];
    
    $query = "SELECT * FROM solicitud WHERE id_viaje='".$trip["id_viaje"]."' AND estado=".ACCEPTED;
    $result = mysqli_query($conn, $query);
    
    return $total_seats - mysqli_num_rows($result);
  }

  function isPendingTrip($conn, $trip){
    $now = time();
    if((!isset($trip["tipo"])) || ($trip["tipo"] == ONE_TIME_TRIP)){
      $date = strtotime($trip["fecha_hora"]);
      return ($date > $now);
    } else {
      $query = "SELECT * FROM viaje_semanal WHERE id_viaje=".$trip["id_viaje"];
      $trips = mysqli_query($conn, $query);
      while($weeklyTrip = mysqli_fetch_assoc($trips)){
        if(strtotime($weeklyTrip["fecha_hora"]) > $now){
          return true;
        }
      }
      return false;
    }
  }

  function isFinishedTrip($datetime, $duration){
    $now = time();
    $finishTime = strtotime($datetime) + ($duration*60*60);
    //echo "Fecha: $datetime - Duracion: $duration - Finalizacion: ".date("d/m/Y H:i:s", $finishTime)."<br>";
    return ($finishTime < $now);
  }

  function finishTime($datetime, $duration){
    return date("Y-m-d H:i:s",strtotime($datetime) + ($duration*60*60)); 
  }
  
  function vehicleHasPendingTrips($conn, $plate){
    $now = time();
    $query = "SELECT * FROM viajes WHERE patente='$plate'";
    $result = mysqli_query($conn, $query);
    while($trip = mysqli_fetch_assoc($result)){
      if(isPendingTrip($conn, $trip)){
        return true;
      }
    }
    return false;
  }

  function isExpiredCard($conn, $card_number, $date){
    $query = "SELECT * FROM tarjetas WHERE numero=$card_number";
    $card = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $expiration = DateTime::createFromFormat("Y-m-d", $card["vencimiento"]);
    $today = DateTime::createFromFormat("Y-m-d", $date);
    return ($today >= $expiration);
  }
  
  function isExpiredCardCommonDate($conn, $card_number, $date){
    $query = "SELECT * FROM tarjetas WHERE numero=$card_number";
    $card = mysqli_fetch_assoc(mysqli_query($conn, $query));
    $expiration = DateTime::createFromFormat("Y-m-d", $card["vencimiento"]);
    $today = DateTime::createFromFormat("Y-m-d H:i:s", $date);
    return ($today >= $expiration);
  }

  function formatCard($number){
    return "xxxxxxxxxxxx".substr($number, -4);
  }

  function formatPrice($price){
    return substr($price, 0, 6);
  }

  function alreadyHaveRequest($conn, $user_id, $trip_id){
    $query = "SELECT * FROM solicitud WHERE id_pasajero='$user_id' AND id_viaje='$trip_id' ";
    $requests = mysqli_query($conn, $query);
    return mysqli_num_rows($requests) > 0;
  }

  function debug($conn){
    echo mysqli_error($conn)."<br>";
    exit();
  }

  function formatDate($date){
    return (new DateTime($date))->format("d/m/Y H:i");
  }


  /* Recibe la informacion del viaje y retorna las fechas (array de string) de todos los viajes individuales.
     $days: array del 1 al 7 con un booleano que esta en true si ese dia se viaja
     $time: hora en formato hh:mm:ss del viaje
     $weeks: semanas que se repite
  */
  function createWeeklyTrips($days, $time, $weeks){
    $trips = array();
    $dayOfWeek = intval(date("N"));
    $today = time();
    for($i = $dayOfWeek + 1; $i <= 7; $i++){
      if($days[$i]){
        $date = $today + (($i - $dayOfWeek)*24*60*60);
        $dateTime = date("Y-m-d", $date)." ".$time;
        array_push($trips, $dateTime);
      }
    }
    $sunday = $today + ((7 - $dayOfWeek)*24*60*60);
    for($week = 0; $week <= $weeks-2; $week++){
      for($day = 1; $day <= 7; $day++){
        if($days[$day]){
          $date = $sunday + ($day*24*60*60) + ($week*7*24*60*60);
          $dateTime = date("Y-m-d", $date)." ".$time;
          array_push($trips, $dateTime);  
        }
      }
    }
    return $trips;
  }

  function daysOfTrips($trips){
    $arrayDays = array();
    while ($result = mysqli_fetch_array($trips)){
      $arrayDays[] = date('N', strtotime($result["fecha_hora"]));
    }
    $arrayDays = array_unique($arrayDays);
    return $arrayDays;
  }

  function haveRequest($conn, $trip_id){
    $query = "SELECT * FROM solicitud WHERE id_viaje='$trip_id' ";
    $requests = mysqli_query($conn, $query);
    return mysqli_num_rows($requests) > 0;
  }
  function countRequests($trip_id, $conn){
    $query = "SELECT * FROM solicitud WHERE id_viaje=$trip_id";
    $result = mysqli_query($conn, $query);
    return mysqli_num_rows($result);
  }
?>

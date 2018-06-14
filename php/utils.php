<?php
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
    $query = "SELECT * FROM puntua_pasajero WHERE id_conductor='".$id."' AND estado=0";
    $result = mysqli_query($conn, $query);
    if($result){
      while($cal = mysqli_fetch_assoc($result)){
        $date = new DateTime($cal["fecha"]);
        if($today->diff($date)->m >= 1){
          return true;
        }
      }
    }
    $query = "SELECT * FROM puntua_conductor WHERE id_pasajero='".$id."' AND estado=0";
    $result = mysqli_query($conn, $query);
    if($result){
      while($cal = mysqli_fetch_assoc($result)){
        $date = new DateTime($cal["fecha"]);
        if($today->diff($date)->m >= 1){
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
?>
<?php
  include("verficar_sesion.php");
  include("utils.php");

  include("abrir_conexion.php");
  $trip_id = $_POST['trip_id'];
  $user_id = $_SESSION['user_id'];
  $query = "SELECT * FROM solicitud WHERE id_viaje='$trip_id' AND estado=" .ACCEPTED;
  if(($oc = dbOcurrences($conn, $query )) > 0 ){

    $query= "SELECT * FROM usuario WHERE id_usuario='$user_id' ";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user['promedio_puntuacion_conductor'] > 0){
      $average = $user['promedio_puntuacion_conductor'] - 1;
      $query = "UPDATE usuario SET promedio_puntuacion_conductor='$average' WHERE id_usuario='$user_id'";
      $result = mysqli_query($conn, $query);
    }
    $query = "DELETE FROM viajes WHERE id_viaje='$trip_id'";
	  $result = mysqli_query($conn, $query);
    header("location: /vistas/ver_viajes.php?trip_removed_with_average");
	  exit();
  }else{
    $query = "DELETE FROM viajes WHERE id_viaje='$trip_id'";
	  $result = mysqli_query($conn, $query);
    header("location: /vistas/ver_viajes.php?trip_removed");
	  exit();
  }
  include("cerrar_conexion.php");

?>
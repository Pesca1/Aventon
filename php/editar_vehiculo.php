<?php
  session_start();
  ob_start();
  $actual_patent = $_SESSION['actual_patent'];
  $new_patent = $_POST['patent'];
  $new_seating= $_POST['seating'];

  include("abrir_conexion.php");

  $query = "SELECT * FROM vehiculo WHERE patente='$actual_patent'";
  $result = mysqli_query($conn, $query);
  $vehicle = mysqli_fetch_assoc($result);

  if ($new_patent != ""){
    $car_old_patent = "/[A-Za-z]{3}[0-9]{3}/";
    $car_new_patent = "/[A-Za-z]{2}[0-9]{3}[A-Za-z]{2}/";
    $motorcycle_old_patent = "/[0-9]{3}[A-Za-z]{3}/";
    $motorcycle_new_patent = "/[A-Za-z]{1}[0-9]{3}[A-Za-z]{3}/";

    if (preg_match($car_old_patent, $new_patent) || preg_match($car_new_patent, $new_patent) || preg_match($motorcycle_old_patent, $new_patent) ||preg_match($motorcycle_new_patent, $new_patent)){
    }else {
      header("location: /vistas/editar_vehiculo.php?error_patent");
    }
  }else {
    $new_patent = $vehicle['patente'];
  }

  if ($new_seating == ""){
    $new_seating = $vehicle['asientos'];
  }

  $query = "UPDATE vehiculo SET patente='$new_patent', asientos='$new_seating'";
  mysqli_query($conn, $query);
  include("cerrar_conexion.php");

  header("Location: /vistas/listar_vehiculos.php?success_change");
 ?>

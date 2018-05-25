<?php


$car_brand = $car_model = $car_patent = $car_seating = $car_pic = "";

include("test_input.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $car_brand = test_input ($_POST['brand']);
  $car_model = test_input($_POST['model']);
  $car_patent = test_input($_POST['patent']);
  $car_seating = test_input($_POST['seating']);
  $car_pic = test_input($_POST['car_picture']);
}

 include("abrir_conexion.php");

$sql = "INSERT INTO vehiculo (patente, id_usuario, marca, modelo, asientos)
VALUES ($car_patent, $_SESSION['user_id'], $car_brand, $car_model, $car_seating )";

if (mysqli_query($conn, $sql)) {
    echo "Se ha dado de alta un nuevo vehículo";
} else {
    header('location: /registrar_vehiculo.php?car_error');;
}

 include("cerrar_conexion.php");

?

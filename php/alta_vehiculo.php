<?php


$car_brand = $car_model = $car_patent = $car_seating = $car_pic = "";

include("verficar_sesion.php");
include("test_input.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
  $car_brand = test_input ($_POST['brand']);
  $car_model = test_input($_POST['model']);
  $car_patent = test_input($_POST['patent']);
  $car_seating = test_input($_POST['seating']);
}

include("abrir_conexion.php");

$id = $_SESSION['user_id'];

$sql = "INSERT INTO vehiculo (patente, id_usuario, marca, modelo, asientos) VALUES('$car_patent', $id, '$car_brand', '$car_model', $car_seating)";
if(mysqli_query($conn, $sql)){
	for($i = 1; $i <= intval($_POST['picture_number']); $i++){
	 	$picture = $_FILES["car_picture_".$i];
	 	if(($picture["name"]!="")&&($picture["size"]<=5000000)&&($picture["size"]>0)){
	 		$target_dir = "../img/vehicles/";
	 		$ext = "." . pathinfo($picture["name"], PATHINFO_EXTENSION);
	      	$picture_name = $car_patent . "-". $i . $ext;
	      	$target_file = $target_dir . $picture_name;
	      	if(move_uploaded_file($picture["tmp_name"], $target_file)){
	      		$sql = "INSERT INTO fotos_vehiculo (patente, foto) VALUES ('$car_patent', '$picture_name')";
	      		if(mysqli_query($conn, $sql)){
	      			header('location: /vistas/listar_vehiculos.php?success');
	      		} else {
	      			echo "Error sql: ".mysqli_error($conn);
	      		}
	      	}
	 	}
	 }
} else {
	header('location: /php/registrar_vehiculo.php?car_error');
}

/*if (mysqli_query($conn, $sql)) {
    header('location: /vistas/listar_vehiculos.php?success');
} else {
    header('location: /php/registrar_vehiculo.php?car_error');
}*/

 include("cerrar_conexion.php");

?>
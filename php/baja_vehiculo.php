<?php

include("verficar_sesion.php");
include("abrir_conexion.php");
include("utils.php");

$plate = $_POST['plate'];

if(vehicleHasPendingTrips($conn, $plate)){
	header("Location: /vistas/listar_vehiculos.php?pending");
} else {
	$query = "SELECT * FROM fotos_vehiculo WHERE patente='$plate'";
	$result = mysqli_query($conn, $query);
	while($photo = mysqli_fetch_assoc($result)['foto']){
		if(!(unlink("../img/vehicles/".$photo))){
			echo "<br>No fue posible eliminar la foto ". $photo;
		}
	}
	$query = "DELETE FROM fotos_vehiculo WHERE patente='$plate'";
	$result = mysqli_query($conn, $query);
	if($result){
		$query = "DELETE FROM vehiculo WHERE patente='$plate'";
		$result = mysqli_query($conn, $query);
		if($result){
			header("Location: /vistas/listar_vehiculos.php?deleted");
		} else {
			header("Location: /vistas/listar_vehiculos.php?error");
		}
	} else {
		header("Location: /vistas/listar_vehiculos.php?error");
	}
}

include("cerrar_conexion.php");

?>

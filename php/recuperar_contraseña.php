<?php
	include("abrir_conexion.php");

	echo "Hola"

	$query = "SELECT contrasenia FROM usuario WHERE mail='$mail'";

	$sent = mail("joaquindea@hotmail.es", "Contraseña de Aventon", "Tu contraseña es: caca");
	if($sent){
		/*header("Location: /index.php?recover=true");*/
	} else {
		/*header("Location: /index.php?recover=false");*/
	}


	include("cerrar_conexion.php");
?>
<?php
	include("abrir_conexion.php");

	$user_mail = $_POST['user_mail'];

	$query = "SELECT contrasenia FROM usuario WHERE mail='$user_mail'";
	$result = mysqli_query($conn, $query);
	if($user = mysqli_fetch_assoc($result)){
		$passwd = $user['contrasenia'];
		$sent = mail("$user_mail", "Recuperacion de clave de Aventon", "Hola! Nos comunicamos para recordarte tu clave. Clave: $passwd.\nSaludos,\nEquipo de Aventon ");
		if($sent){
			header("Location: /index.php?recover=true");
		} else {
			// header("Location: /index.php?recover=false");
			echo "Error: ".error_get_last()["message"]."<br>";
		}
	} else {
		header("Location: /index.php?wrong_email");
	}


	include("cerrar_conexion.php");
?>

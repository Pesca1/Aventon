<?php
  $my_sql_user = "root";
  $my_sql_password = "";
  $my_sql_server = "localhost";
  $my_sql_db= "aventon";

  $conn = mysqli_connect($my_sql_server, $my_sql_user, $my_sql_password, $my_sql_db);
  if(!$conn){
  	echo "No fue posible conectarse: ".mysql_error();
  } else {
  	echo "Conexion exitosa<br>";
  }

  $user_name = mysqli_real_escape_string($conn, $_POST['name']);
  $user_mail = mysqli_real_escape_string($conn, $_POST['mail']);
  $user_birth_day = mysqli_real_escape_string($conn, $_POST['birth_day']);
  $user_birth_month = mysqli_real_escape_string($conn, $_POST['birth_month']);
  $user_birth_year = mysqli_real_escape_string($conn, $_POST['birth_year']);
  $user_password = mysqli_real_escape_string($conn, $_POST['password']);
  $user_password_confirm = mysqli_real_escape_string($conn, $_POST['password_confirmation']);

  $query = "SELECT * FROM usuario WHERE mail='$user_mail'";
  $result = mysqli_query($conn, $query);

  if(mysqli_fetch_assoc($result)){
  	echo "Ingrese el mail otra vez<br>";
  } else {
  	echo "Registrando";
  	$query = "INSERT INTO usuario (nombre, mail, contrasenia) VALUES('$user_name', '$user_mail', '$user_password')";
  	mysqli_query($conn, $query);
  	echo "registrado.";
  }
  
  mysqli_close($conn);
?>

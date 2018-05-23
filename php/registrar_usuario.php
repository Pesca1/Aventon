<?php
  include("abrir_conexion.php");

  $user_name = mysqli_real_escape_string($conn, $_POST['name']);
  $user_mail = mysqli_real_escape_string($conn, $_POST['mail']);
  $user_birth_day = mysqli_real_escape_string($conn, $_POST['birth_day']);
  $user_birth_month = mysqli_real_escape_string($conn, $_POST['birth_month']);
  $user_birth_year = mysqli_real_escape_string($conn, $_POST['birth_year']);
  $user_password = mysqli_real_escape_string($conn, $_POST['password']);
  $user_surname = mysqli_real_escape_string($conn, $_POST['surname']);

  $query = "SELECT * FROM usuario WHERE mail='$user_mail'";
  $result = mysqli_query($conn, $query);

  if(mysqli_fetch_assoc($result)){
  	header("Location: /index.php?reg=false");
  } else {

    $query = "INSERT INTO usuario (nombre, apellido, mail, contrasenia, fecha_de_nacimiento) VALUES('$user_name', '$user_surname', '$user_mail', '$user_password', STR_TO_DATE('$user_birth_day-$user_birth_month-$user_birth_year', '%d-%m-%Y'))";
    mysqli_query($conn, $query);
  	
    if(($_FILES["profile_picture"]["name"] != "") && ($_FILES['profile_picture']["size"] <= 5000000) && ($_FILES['profile_picture']["size"] > 0)){
      echo "Subiendo foto<br>";
      echo "tamaño: " . $_FILES['profile_picture']["size"] . "<br>";
      $target_dir = "../img/profile_users/";

      $query = "SELECT id_usuario FROM usuario WHERE mail='$user_mail'";
      $result = mysqli_query($conn, $query);
      $id = mysqli_fetch_assoc($result)["id_usuario"];

      $ext = "." . pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
      $picture_name = "user". $id . $ext;
      $target_file = $target_dir . $picture_name;

      $query = "UPDATE usuario SET foto_perfil='$picture_name' WHERE id_usuario=$id";
      $result = mysqli_query($conn, $query);

      if(move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)){
        echo "Archivo subido a ". $target_file;
      } else {
        echo "Error!".mysqli_error($conn);
      }
    }
  	
    header("Location: /index.php?reg=true");
  }

include("cerrar_conexion.php");

?>

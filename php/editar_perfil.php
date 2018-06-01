<?php
  session_start();
  ob_start();
  $user_mail = $_POST['edit_mail'];
  $user_name = $_POST['edit_name'];
  $user_surname = $_POST['edit_surname'];
  $user_id = $_SESSION['user_id'];

  include("abrir_conexion.php");

  if ($user_mail == ''){
    $user_mail = $_SESSION['user_mail'];
  }
  if ($user_name == ''){
    $user_name = $_SESSION['user_name'];
  }
  if ($user_surname == ''){
    $user_surname = $_SESSION['user_surname'];
  }

  if(($_FILES["profile_image"]["name"] != "") && ($_FILES['profile_image']["size"] <= 5000000) && ($_FILES['profile_image']["size"] > 0)){
    $target_dir = "../img/profile_users/";
    $id = $_SESSION['user_id'];
    echo $_FILES["profile_image"]["name"];
    $ext = "." . pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION);
    $picture_name = "user". $id . $ext;
    $target_file = $target_dir . $picture_name;

    if(move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)){
      echo "Archivo subido a ". $target_file;
    } else {
      echo "Error!".mysqli_error($conn);
    }
  }else {
    $picture_name = $_SESSION['user_image'];
  }

  $consulta="SELECT * FROM usuario WHERE mail = '$user_mail'";
  $result = mysqli_query($conn, $consulta);
  
  if ((mysqli_num_rows($result)== 0) || ($_SESSION["user_mail"] == $user_mail)) {

  $sSQL="UPDATE usuario SET nombre='$user_name', apellido='$user_surname',
                            mail='$user_mail', foto_perfil= '$picture_name'
                            WHERE id_usuario='$user_id' ";
  mysqli_query($conn, $sSQL);
  include("cerrar_conexion.php");

  $_SESSION['user_name'] = $user_name;
  $_SESSION['user_surname'] = $user_surname;
  $_SESSION['user_mail'] = $user_mail;
  $_SESSION['user_image'] = $picture_name;

  header("Location: /vistas/ver_perfil.php?success_change");
}
else {
     header("location: /vistas/editar_perfil.php?mail_error");
     exit();
    }

 ?>

<?php
  session_start();
  ob_start();
  $actual_pass = $_POST['actual_pass'];
  $new_pass = $_POST['new_pass'];
  $repeated_new_pass = $_POST['repeated_new_pass'];


  if ($new_pass != $repeated_new_pass){
    header('location: ../vistas/editar_contrasenia.php?diff_pass');
  }else {
    include("abrir_conexion.php");

    $user_id = $_SESSION['user_id'];
    $query = "SELECT contrasenia from $table_user WHERE id_usuario = '$user_id'";
    $result = mysqli_query($conn, $query);

    $consult = mysqli_fetch_assoc($result);
    if ($consult['contrasenia'] != $actual_pass){
      header('location: ../vistas/editar_contrasenia.php?wrong_pass');
    }else {
      $query= "Update usuario Set contrasenia='$new_pass' Where id_usuario='$user_id' ";
      mysqli_query($conn, $query);
      header('location: ../vistas/ver_perfil.php?success_change');
    }

    include("cerrar_conexion.php");
  }
 ?>

<?php
  include("abrir_conexion.php");
  
  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
  }

  function newPictureName($ext, $conn){
    $name = generateRandomString().$ext;
    $query = "SELECT * FROM fotos_vehiculo WHERE foto='$name'";
    $result = mysqli_query($conn, $query);
    while(mysqli_fetch_assoc($result)){
      $name = generateRandomString().$ext;
      $query = "SELECT * FROM fotos_vehiculo WHERE foto='$name'";
      $result = mysqli_query($conn, $query);  
    }
    return $name;
  }

  session_start();
  ob_start();
  $actual_patent = $_SESSION['actual_patent'];
  $new_patent = $_POST['patent'];
  $new_seating= $_POST['seating'];

  $query = "SELECT * FROM vehiculo WHERE patente='$actual_patent'";
  $result = mysqli_query($conn, $query);
  $vehicle = mysqli_fetch_assoc($result);

  if (($new_patent != "") && ($new_patent != $actual_patent)){
    
    $query2 = "SELECT * FROM vehiculo WHERE patente='$new_patent'";
    $result = mysqli_query($conn, $query2);

    if (mysqli_num_rows($result) > 0) {
      
      header("location: /vistas/editar_vehiculo.php?duplicated_patent=$actual_patent");
      exit();
    }


    $car_old_patent = "/[A-Za-z]{3}[0-9]{3}$/";
    $car_new_patent = "/[A-Za-z]{2}[0-9]{3}[A-Za-z]{2}$/";

    if (preg_match($car_old_patent, $new_patent) || preg_match($car_new_patent, $new_patent)){
    }else {
      header("location: /vistas/editar_vehiculo.php?error_patent=$actual_patent");
      exit();
    }
  }else {
    $new_patent = $vehicle['patente'];
  }

  if ($new_seating == ""){
    $new_seating = $vehicle['asientos'];
  }

  $query = "UPDATE vehiculo SET patente='$new_patent', asientos='$new_seating' WHERE patente='$actual_patent'";
  mysqli_query($conn, $query);

  $query = "UPDATE fotos_vehiculo SET patente='$new_patent' WHERE patente='$actual_patent'";
  mysqli_query($conn, $query);

  for($i = 1; $i <= intval($_POST['delete_number']); $i++){
    $picture = $_POST["delete_picture_".$i];
    $target_file = "../img/vehicles/". $picture;
    $query = "DELETE FROM fotos_vehiculo WHERE foto='$picture'";
    $result = mysqli_query($conn, $query);
    if($result){
      unlink($target_file);
    }
  }

  for($i = 1; $i <= intval($_POST['picture_number']); $i++){
    $picture = $_FILES["car_picture_".$i];
    if(($picture["name"]!="")&&($picture["size"]<=5000000)&&($picture["size"]>0)){
      $target_dir = "../img/vehicles/";
      $ext = "." . pathinfo($picture["name"], PATHINFO_EXTENSION);
      $picture_name = newPictureName($ext, $conn);
      $target_file = $target_dir . $picture_name;
      if(move_uploaded_file($picture["tmp_name"], $target_file)){
        $sql = "INSERT INTO fotos_vehiculo (patente, foto) VALUES('$new_patent', '$picture_name')";
        if(mysqli_query($conn, $sql)){
      	  header('location: /vistas/listar_vehiculos.php?success');
      	} else {
 	  echo "Error sql: ".mysqli_error($conn);
      	}
      }
    }
  }
  include("cerrar_conexion.php");

  header("Location: /vistas/listar_vehiculos.php?success_change");
 ?>

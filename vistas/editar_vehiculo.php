<?php include("../php/verficar_sesion.php"); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <title>Aventón</title>
  <meta charset= "UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
  <link href="/css/index.css" rel="stylesheet" type="text/css">
  <link href="/css/editar_vehiculo.css" rel="stylesheet" type="text/css">
</head>
<body>
  <?php 
    include("header.php");
    include("../php/abrir_conexion.php");
    if (isset($_POST['plate'])){

      $plate = $_SESSION['actual_patent'] = $_POST['plate'];

    }elseif (isset($_GET['error_patent'])){

      $plate = $_SESSION['actual_patent'] = $_GET['error_patent'];

    }elseif(isset($_GET['duplicated_patent'])){
      $plate = $_SESSION['actual_patent'] = $_GET['duplicated_patent'];
    }

    $image_path = "/img/vehicles/";
    
    $query = "SELECT asientos FROM vehiculo WHERE patente='$plate'";
    $result = mysqli_query($conn, $query);
    if($result){
      $seats = mysqli_fetch_assoc($result)["asientos"];
    } else {
      $seats = "0";
    }

    $query = "SELECT foto FROM fotos_vehiculo WHERE patente='$plate'";
    $result = mysqli_query($conn, $query);
  ?>
  <br>
  <div class="container">
    <h5>Editar vehículo</h5><br><br>
    <form action="/php/editar_vehiculo.php" method="post" enctype="multipart/form-data" >
      <div class="form-row">
        <div class="form-group col-md-5">
          <label>Nueva patente (Dejar en blanco para conservar patente):</label>
          <input id="plate" type="text" class="form-control" name="patent" value="<? echo $plate ?>">
          <label>Asientos disponibles:</label>
          <input type="number" class="form-control" name="seating" min="1" max="45" value= "<? echo $seats?>" required="required">
        </div>
        <div class="col-md-1">
        </div>
        <div id="old_pictures">
          <?
            if($result){
              while($photo = mysqli_fetch_assoc($result)['foto']){
                echo "<div class='picture-container'><img class='picture' src=" . $image_path . $photo ." />";
                echo "<input type='hidden' class='picture_name' value='$photo' />";
                echo "<button class='btn btn-warning' >Eliminar</button></div>";
              }
            }
          ?>
        </div>
        <input type="hidden" name="delete_number" value="0" id="delete_number"/>
        <div class="form-group col-md-6"><br><br>
          <input type="hidden" name="picture_number" value="1" id="number"/>
          <div id="pictures">
            <input type="file" name="car_picture_1" formenctype="multipart/form-data" class="registrovehiculo">
          </div>
          <br>
          <button class="btn btn-secondary" id="add_photo">Agregar foto</button>
        </div>
      </div>
      <button type="submit" class="btn btn-primary" id="edit">Guardar</button>
    </form>
  </div>

</body>
<?php include("../vistas/bootstrap.php"); ?>
<script src="/js/registrar_usuario.js"></script>
<script type="text/javascript" src="/js/registrar_vehiculo.js"></script>
<?php
  if(isset($_GET['error_patent'])){
    echo '<script> show_error("¡Tipo de patente no valido!"); </script>';
  }
  if(isset($_GET['duplicated_patent'])){
    echo '<script> show_error("Ya existe un vehículo con la patente"); </script>';
  }
?>
</html>
<?php include("../php/cerrar_conexion.php"); ?>

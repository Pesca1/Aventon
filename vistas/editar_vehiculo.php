<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Aventón</title>
    <meta charset= "UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/index.css" rel="stylesheet" type="text/css">
  </head>
  <body>
     <?php include("header.php");
      $_SESSION['actual_patent'] = $_POST['actual_patent'];
      ?><br>
     <div class="container">
       <h5>Editar vehículo</h5><br><br>
       <form action="/php/editar_vehiculo.php" method="post" enctype="multipart/form-data">
            <div class="form-row">
              <div class="form-group col-md-5">
                <label>Nueva patente:</label>
                <input type="text" class="form-control" name="patent">
                <label>Asientos disponibles:</label>
                <input type="number" class="form-control" name="seating" min="1" max="45" value= "1" required="required">
              </div>
              <div class="col-md-1">

              </div>
              <div class="form-group col-md-6"><br><br>
                <?php
                  session_start();
                  ob_start();

                  include("../php/abrir_conexion.php");
                  $id = $_SESSION['user_id'];
                  $query = "SELECT * FROM vehiculo WHERE id_usuario='$id'";
                  $result = mysqli_query($conn, $query);
                  if($result){
                    $vehicle = mysqli_fetch_assoc($result);
                    if($vehicle){
                      while($vehicle) {
                        $plate = $vehicle['patente'];
                        $query = "SELECT foto FROM fotos_vehiculo WHERE patente='$plate'";
                        $photo_query = mysqli_query($conn, $query);
                      }
                    }
                  }
                  include("../php/cerrar_conexion.php");
                 ?>


                <input type="hidden" name="picture_number" value="1" id="number"/>
                <div id="pictures">
                  <input type="file" name="car_pic_1" formenctype="multipart/form-data" class="registrovehiculo">
                </div><br>
                <button class="btn btn-secondary" id="add_photo">Agregar foto</button>
              </div>
            </div>


             <button type="submit" class="btn btn-primary">Guardar</button>
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
  ?>
</html>

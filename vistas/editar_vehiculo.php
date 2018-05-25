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
    <?php
      include("../php/verficar_sesion.php");
     ?>
     <?php include("header.php");
      $_SESSION['actual_patent'] = $_POST['actual_patent'];
      ?><br>
     <div class="container">
       <div class="row">
         <div class="col-md-4">
           <br><h5>Editar vehiculo</h5>
         </div>
         <div class="col-md-4"><br><br><br><br><br><br>
           <form action="/php/editar_vehiculo.php" method="post">
             <div class="form-group">
               <label>Nueva patente:</label>
               <input type="text" class="form-control" name="patent">
             </div>
             <div class="form-group">
               <label>Asientos disponibles:</label>
               <input type="number" class="form-control" name="seating" min="1" max="45" value= "1" required="required">
             </div>
             <button type="submit" class="btn btn-primary">Guardar</button>
           </form>
         </div>
       </div>
     </div>

  </body>
  <?php include("../vistas/bootstrap.php"); ?>
  <script src="/js/registrar_usuario.js"></script>
  <?php
    if(isset($_GET['error_patent'])){
      echo '<script> show_error("¡Tipo de patente no valido!"); </script>';
    }
  ?>
</html>

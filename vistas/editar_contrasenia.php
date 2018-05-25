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
     <?php include("header.php"); ?><br>
     <div class="container">
       <div class="row">
         <div class="col-md-12">
           <h5>Cambiar contraseña</h5>
         </div><br><br>
         <div class="col-md-4"></div>
         <div class="col-md-4">
           <form class="" action="/php/editar_contrasenia.php" method="post">
             <div class="form-group">
               <label>Contraseña actual:</label>
               <input class="form-control" type="password" name="actual_pass">
             </div><br><br>
             <div class="form-group">
               <label>Nueva contraseña:</label>
               <input class="form-control" type="password" name="new_pass">
             </div>
             <div class="form-group">
               <label>Vuelva a ingresar la nueva contraseña:</label>
               <input class="form-control" type="password" name="repeated_new_pass">
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
  if(isset($_GET['diff_pass'])){
    echo '<script> show_error("Las contraseñas no coinciden"); </script>';
  }
  if(isset($_GET['wrong_pass'])){
    echo '<script> show_error("Contraseña acutal incorrecta"); </script>';
  }
  ?>
</html>

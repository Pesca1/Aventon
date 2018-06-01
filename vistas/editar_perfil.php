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
        <h5>Editar perfil</h2><br><br>
            <form method="POST" action="/php/editar_perfil.php" enctype="multipart/form-data">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="">Foto de perfil</label><br>
                  <?php 
                    $user_img = "/img/profile_users/".$_SESSION['user_image'];
                    if($user_img == "/img/profile_users/"){
                      $user_img = "/img/system/default_user.jpg";
                    }
                  ?>
                  <img src="<?php echo $user_img;?>" width="150" height="150"><br><br>
                  <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
                  <input type="file" name="profile_image">
                </div>
                <div class="form-group col-md-8">
                  <div class="row">
                    <div class="form-group col-md-12">
                      <label for="inputEmail4">Email</label>
                      <input type="email"name="edit_mail" class="form-control" id="inputEmail4" placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputName">Nombre</label>
                      <input type="text" name="edit_name" class="form-control" id="inputName">
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputSurname">Apellido</label>
                      <input type="text" name="edit_surname" class="form-control" id="inputSurname">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-11">
                </div>
                <div class="col-md-1">
                  <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
              </div>
            </form>
     </div>



  </body>
  <?php include("../vistas/bootstrap.php");  ?>
  <script type="text/javascript" src="/js/registrar_usuario.js"></script>;
  
  
  <?php
if(isset($_GET['mail_error'])){
      echo '<script> show_error("Debe ingresar un mail que no esté registrado en el sistema."); </script>';
    }



  ?>
</html>

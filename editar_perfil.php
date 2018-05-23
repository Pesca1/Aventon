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
      include("php/verficar_sesion.php");
     ?>
     <div id="header">
       <h2>Aventón</h2>
       <form class="" action="/php/cerrar_sesion.php" method="get">
         <button type="submit" class="btn btn-outline-danger" action="/php/cerrar_sesion.php">Cerrar sesión</button>
       </form>
       <form class="" action="editar_perfil.php" method="get">
         <button type="submit" class="btn btn-outline-success" action="/php/editar_perfil.php">Editar perfil</button>
       </form>
     </div><br>

     <div class="container">
        <h5>Editar perfil</h2><br><br>
            <form method="POST" action="/php/editar_perfil.php">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label for="">Foto de perfil</label><br>
                  <img src="/img/system/example.jpg" width="150" height="150"><br><br>
                  <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
                  <input type="file" class="form-control-file" name="profile_picture" id="exampleFormControlFile1">
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
  <?php include("php/bootstrap.php"); ?>
</html>

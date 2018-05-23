<?php 
  session_start();
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    header("Location: pantalla_principal.php");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Aventón</title>
    <meta charset= "UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/index.css" rel="stylesheet" type="text/css">
  </head>
  <body>
      <div id="header">
        <img id="logo" src="/img/logo.jpeg" />
      </div>
      <div id="body">
        <h1>Bienvenido a Aventón!</h1>
          <div class="form_container">
            <h2>Iniciar sesión</h2>
            <form method="POST" action="/php/iniciar_sesion.php">
              <div class="form-group col-md-6">
                <h3>Ingrese su mail:</h3>
                <input type="email" class="form-control" name="mail" required="required" id="login_mail">
              </div>
              <br>
              <div class="form-group col-md-6">
                <h3>Ingrese su contraseña:</h3>
                <input type="password" class="form-control" name="password" required="required">
              </div>
                <div class="form-group col-md-6">
                  <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </div>
              <br><br>
              <a href="/php/recuperar_contraseña.php" id="recover_passwd">Olvide mi contraseña!</a>
            </form>
          </div>

          <div class="form_container">
            <h2>Crear una cuenta</h2>
            <form enctype="multipart/form-data" action="/php/registrar_usuario.php" method="post" id="register_form">
              <h3>Ingrese su nombre:</h3>
              <input type="text" name="name" required>
              <br>
              <h3>Ingrese su apellido:</h3>
              <input type="text" name="surname" required>
              <br>
              <h3>Ingrese su mail:</h3>
              <input type="email" name="mail" required>
              <br>
              <h3>Ingrese su fecha de nacimiento:</h3>
              Día:
              <select name="birth_day" id="day">
                <?php
                  for($i = 1; $i <= 31; $i++){
                    echo "<option>$i</option>";
                  }
                  ?>
              </select>
               - Mes:
              <select name="birth_month" id="month">
                <?php
                  for($i = 1; $i <= 12; $i++){
                    echo "<option>$i</option>";
                  }
                ?>
              </select>
               - Año:
              <select name="birth_year" id="year">
                <?php
                  for($i = 2000; $i >= 1940; $i--){
                    echo "<option>$i</option>";
                  }
                ?>
              </select>
              <h3>Ingrese su contraseña:</h3>
              <input type="password" name="password" id="passwd" required>
              <br>
              <h3>Ingrese su contraseña nuevamente:</h3>
              <input type="password" name="password_confirmation" id="passwd_confirm" required>
              <br>
              <h3>Seleccione una foto de perfil (Opcional)</h3>
              <input type="hidden" name="MAX_FILE_SIZE" value="5000000">
              <input type="file" name="profile_picture">
              <br>
              <br>
              <input type="submit" text="Iniciar Sesión">
            </form>
        </div>
      </div>
      <?php include("php/footer.php") ?>
  </body>
  <?php include("php/bootstrap.php"); ?>
  <script src="/js/registrar_usuario.js"></script>
  <?php
    if(isset($_GET['reg'])){
      if($_GET['reg'] == 'false'){
        echo '<script> show_error("El mail ya se encuentra registrado."); </script>';
      } else if($_GET['reg'] == 'true'){
        echo '<script> show_success("Registrado con éxito!"); </script>';
      }
    }

    if(isset($_GET['login_error'])){
      echo '<script> show_error("Usuario o contraseña incorrecto."); </script>';
    }
    if(isset($_GET['session_expire'])){
      echo '<script> show_error("Su sesión expiró, por favor ingrese nuevamente."); </script>';
    }
    if(isset($_GET['no_session'])){
      echo '<script> show_error("Debe iniciar sesión para utilizar esta función."); </script>';
    }
    if(isset($_GET['wrong_email'])){
      echo '<script> show_error("El mail ingresado no esta registrado en Aventón."); </script>';
    }

    if(isset($_GET['recover'])){
      if($_GET['recover'] == 'false'){
        echo '<script> show_error("Hubo un error al enviar el email. Vuelva a intentarlo mas tarde."); </script>';
      } else if($_GET['recover'] == 'true'){
        echo '<script> show_success("La contraseña fue enviada a su dirección de email."); </script>';
      }
    }
  ?>
</html>

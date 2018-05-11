<!DOCTYPE html>
<html>
  <head>
    <title>Aventón</title>
    <meta charset= "UTF-8">
    <link href="/css/index.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div id="header">
      <h2>Aventón</h2>
    </div>
    <div id="body">
      <h1>Bienvenido a Aventón!</h1>
      <div class="form_container">
        <h2>Iniciar sesión</h2>
        <form>
          <h3>Ingrese su mail:</h3>
          <input type="email" name="mail">
          <br>
          <h3>Ingrese su contraseña:</h3>
          <input type="password" name="password">
          <br><br>
          <input type="submit" text="Iniciar Sesión">
          <br><br>
          <a href="/php/recuperar_contraseña.php">Olvide mi contraseña!</a>
        </form>
      </div>
      <div class="form_container">
        <h2>Crear una cuenta</h2>
        <form action="/php/registrar_usuario.php" method="post">
          <h3>Ingrese su nombre completo:</h3>
          <input type="text" name="name">
          <br>
          <h3>Ingrese su mail:</h3>
          <input type="email" name="mail">
          <br>
          <h3>Ingrese su fecha de nacimiento:</h3>
          Día: 
          <select name="birth_day">
            <?php
              for($i = 1; $i <= 31; $i++){
                echo "<option>$i</option>";
              }
              ?>
          </select>
           - Mes:
          <select name="birth_month">
            <?php
              for($i = 1; $i <= 12; $i++){
                echo "<option>$i</option>";
              }
            ?>
          </select>
           - Año:
          <select name="birth_year">
            <?php
              for($i = 2000; $i >= 1940; $i--){
                echo "<option>$i</option>";
              }
            ?>
          </select>
          <h3>Ingrese su contraseña:</h3>
          <input type="password" name="password">
          <br>
          <h3>Ingrese su contraseña nuevamente:</h3>
          <input type="password" name="password_confirmation">
          <br>
          <br>
          <input type="submit" text="Iniciar Sesión">
        </form>
      </div>
    </div>
    <div id="footer">
      <a id="help_link"  href="/php/ayuda.php">Ayuda y Contacto</a>
    </div>
  </body>
</html>

<!DOCTYPE html>
<html>
  <head>
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <link href="/css/index.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php
      include("../php/verficar_sesion.php");
      include("../php/abrir_conexion.php");
      include("../php/utils.php");
      include("header.php");
    ?>
    <div id="body">
      <h1>Registrar Tarjeta</h1>
      <form method="post" action="/php/alta_tarjeta.php" id="card_registration" autocomplete="off">
        <br>
        <h3>Número</h3>
        <input type="text" name="card_number" id="card_number" placeholder="Ingrese el número de su tarjeta" required="required"/>
        <br>
        <br>
        <h3>Código de seguridad</h3>
        <input type="password" name="card_code" id="card_code" placeholder="Ingrese el código de seguridad" required="required"/>
        <br>
        <br>
        <h3>Fecha de vencimiento:</h3>
        - Mes:
        <select name="exp_month" id="month">
        <?php
          for($i = 1; $i <= 12; $i++){
            echo "<option>$i</option>";
          }
        ?>
        </select>
        - Año:
        <select name="exp_year" id="year">
        <?php
          for($i = 2018; $i <= 2068; $i++){
            echo "<option>$i</option>";
          }
        ?>
        </select>
        <br>
        <br>
        <input type="submit" class="btn btn-primary" value="Registrar" id="submit"/>
      </form>
    </div>
    <?php
      include("footer.php");
    ?>
  </body>
  <?php 
    include("bootstrap.php"); 
    include("../php/cerrar_conexion.php");
  ?>
  <script src="/js/registrar_usuario.js"></script>
  <script src="/js/registrar_tarjeta.js"></script>
</html>

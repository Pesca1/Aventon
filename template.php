<!DOCTYPE html>
<html>
  <head>
    <title>Aventón</title>
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <link href="/css/index.css" rel="stylesheet" type="text/css">
    <link href="/css/listar_vehiculos.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php
      include("php/verficar_sesion.php");
      include("php/abrir_conexion.php");
      include("php/utils.php");
      include("vistas/header.php");
    ?>
    <div id="body">
      <h1>Título</h1>
      <div class="vehicle"> <!-- Si es una lista de cosas, se puede utilizar esta extructura y linkear css/listar_vehiculos.css -->
        <div class="vehicle-info">
          <h3>Elemento</h3>
          Características
	  <br>
          <br>
	  <form class="" action="/vistas/editar_tarjeta.php" method="post">
            <input type="hidden" name="card_number" value="">
            <button class="btn" name="">Modificar Información</button>
          </form>
	  <form class="" action="/php/baja_tarjeta.php" method="post">
            <input type="hidden" name="card_number" value="">
            <button class="btn btn-danger delete_card" name="">Eliminar</button>
          </form>
        </div>
      </div>
    </div>
    <?php
      include("vistas/footer.php");
    ?>
  </body>
  <?php 
    include("vistas/bootstrap.php"); 
    include("php/cerrar_conexion.php");
  ?>
  <script src="/js/registrar_usuario.js"></script>
</html>

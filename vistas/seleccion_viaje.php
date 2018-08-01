<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");

  if(dbOcurrences($conn, "SELECT * FROM vehiculo WHERE id_usuario='".$_SESSION["user_id"]."'") == 0){
    header("Location: /vistas/ver_viajes.php?no_car");
  } else if(dbOcurrences($conn, "SELECT * FROM tarjetas WHERE id_usuario='".$_SESSION["user_id"]."'") == 0){
    header("Location: /vistas/ver_viajes.php?no_card");
  } else if(hasOldCalifications($conn, $_SESSION["user_id"])) {
    header("Location: /vistas/ver_viajes.php?pending_califications");
  }
?>
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
      include("header.php");
    ?>
    <div id="body">
      <h1>Tipo de viaje</h1>
      <h2>¿Desea crear un viaje ocasional o recurrente?</h2>
      <br>
      <a class="btn btn-primary" href="/vistas/registrar_viaje.php">Ocasional</a>
      <a class="btn btn-primary" href="/vistas/registrar_viaje_semanal.php">Recurrente</a>
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
</html>

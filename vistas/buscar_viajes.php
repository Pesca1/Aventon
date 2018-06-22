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
      include("../php/verficar_sesion.php");
      include("../php/abrir_conexion.php");
      include("../php/utils.php");
      include("header.php");
    ?>
    <div id="body">
      <h1>Viajes encontrados</h1>
      <?php
        $query = "SELECT * FROM viajes WHERE id_usuario != ".$_SESSION["user_id"];
        $trips = mysqli_query($conn, $query);
        if(mysqli_num_rows($trips)==0){
          echo "<h2>No se encontró ningún viaje!</h2>";
        } else {
          while($trip = mysqli_fetch_assoc($trips)){
            $query = "SELECT * FROM usuario WHERE id_usuario=".$trip["id_usuario"];
            $driver = mysqli_fetch_assoc(mysqli_query($conn, $query));
      ?>
      <div class="vehicle">
        <div class="vehicle-info">
          <h3><?= $trip["origen"]." --> ".$trip["destino"] ?></h3>
          Fecha: <?= $trip["fecha_hora"] ?> - 
          Duración: <?= printTime($trip["duracion"]) ?> - 
          Conductor: <?= $driver["nombre"]." ".$driver["apellido"] ?>
      	  <br>
          <br>
      	  <form class="" action="/vistas/crear_solicitud.php" method="post">
            <input type="hidden" name="trip_id" value="<?= $trip["id_viaje"] ?>">
            <button class="btn btn-primary" name="">Quiero viajar!</button>
          </form>
        </div>
      </div>
      <?php
          }
        }
      ?>
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

<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");
  include("header.php");
  if(dbOcurrences($conn, "SELECT * FROM viajes WHERE id_usuario='".$_SESSION["user_id"]."'") == 0){
    header("Location: /vistas/ver_perfil.php?no_requests");
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
    <div id="body">
      <h1>Solicitudes de viaje</h1>
      <?php
        $query = "SELECT * FROM viajes WHERE id_usuario='".$_SESSION["user_id"]."'";
        $result = mysqli_query($conn, $query);
        if(!$result){
          echo "<h2>Ocurrió un error al conectarse a la base de datos, por favor, intentelo mas tarde.</h2>";
        } else {
          while($trip = mysqli_fetch_assoc($result)){
            $trip_id = $trip["id_viaje"];
            $query = "SELECT * FROM solicitud WHERE id_viaje='$trip_id'";
            $result1 = mysqli_query($conn, $query);
            if(!$result1){
              echo "<h2>Ocurrió un error al conectarse a la base de datos, por favor, intentelo mas tarde.</h2>";
            } else {
              while($request = mysqli_fetch_assoc($result1)){
                $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='".$request["id_pasajero"]."'"));
      ?>
      <div class="vehicle"> <!-- Si es una lista de cosas, se puede utilizar esta extructura y linkear css/listar_vehiculos.css -->
        <div class="vehicle-info">
          <h3><?= $trip["origen"]." --> ".$trip["destino"].". ".$user["nombre"]." ".$user["apellido"] ?></h3>
          Características
	  <br>
          <br>
          <?php
            if($request["estado"] == PENDING){
          ?>
	  <form class="" action="/php/aceptar_solicitud.php" method="post">
            <input type="hidden" name="request_id" value="<?= $request["id_solicitud"] ?>">
            <button class="btn btn-success" name="">Aceptar</button>
          </form>
	  <form class="" action="/php/cancelar_solicitud.php" method="post">
            <input type="hidden" name="request_id" value="<?= $request["id_solicitud"] ?>">
            <button class="btn btn-danger delete_card" name="">Rechazar</button>
          </form>
          <?php
            } else if($request["estado"] == ACCEPTED){
          ?>
	  <form class="" action="/php/baja_solicitud.php" method="post">
            <input type="hidden" name="request_id" value="<?= $request["id_solicitud"] ?>">
            <button class="btn btn-danger delete_card" name="">Eliminar</button>
          </form>
          <?php
            }
          ?>
        </div>
      </div>
      <?php
              }
            }
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

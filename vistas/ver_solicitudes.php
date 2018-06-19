<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");
  if(dbOcurrences($conn, "SELECT * FROM viajes WHERE id_usuario='".$_SESSION["user_id"]."'") == 0){
    header("Location: /vistas/ver_perfil.php?no_trips");
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
    <?php include("header.php"); ?>
    <div id="body">
      <h1>Solicitudes de viaje</h1>
      <?php
        $request_number = 0;
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
              $request_number += mysqli_num_rows($result1);
              while($request = mysqli_fetch_assoc($result1)){
                $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='".$request["id_pasajero"]."'"));
                  
      ?>
      <div class="vehicle">
        <div class="vehicle-info">
          <h3><?= $user["nombre"]." ".$user["apellido"].": ".$trip["origen"]." --> ".$trip["destino"] ?></h3>
          Fecha: <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?>
          - Duracion: <?= printTime($trip["duracion"])."." ?>
          <?php
            if($request["estado"] == PENDING){
          ?>
          <button class="btn btn-warning">Pendiente</button>
          <br>
          <a class="btn btn-primary" href="/vistas/ver_viaje.php?id=<?= $trip["id_viaje"]?>">Ver viaje</a>
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
          <button class="btn btn-success">Aceptada</button>
          <br>
          <a class="btn btn-primary" href="/vistas/ver_viaje.php?id=<?= $trip["id_viaje"]?>">Ver viaje</a>
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
          if($request_number == 0){
            echo "<h2>No hay ninguna solicitud!</h2>";
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

    <?php
    get_success("deleted_success", "La solicitud ha sido eliminada.");
    get_error("deleted_error", "La solicitud no se pudo eliminar.");
     ?>

</html>

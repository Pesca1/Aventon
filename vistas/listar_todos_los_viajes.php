<!DOCTYPE html>
<html>
  <head> 
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
      <h1>Todos los viajes</h1>
      <?php
        $id = $_SESSION["user_id"];
        $sql = "SELECT * FROM viajes WHERE id_usuario !=".$_SESSION["user_id"];
        $result = mysqli_query($conn, $sql);
        if($result){
          if($trip = mysqli_fetch_assoc($result)){
            while($trip){
              $query = "SELECT * FROM usuario WHERE id_usuario=".$trip["id_usuario"];
              $driver = mysqli_fetch_assoc(mysqli_query($conn, $query));
              $name = $driver["nombre"]." ".$driver["apellido"];
      ?>
          
      <div class="vehicle">
        <div class="vehicle-info">
          <h3><?= $trip["origen"] ?> --> <?= $trip["destino"] ?></h3>
          <?=
            ($trip["tipo"] == WEEKLY_TRIP)?"<strong>Viaje semanal</strong> - Comienza el ":"";
          ?>
          <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?> - Duración:
          <?php
            echo printTime($trip["duracion"]).".";
          ?>
          Conductor: <?= $name ?>
	        <br>
          <br>
	          <form class="" action="/vistas/ver_detalles_viaje.php" method="post">
              <input type="hidden" name="trip_id" value="<?= $trip["id_viaje"]; ?>">
              <button class="btn btn-primary" name="">Ver detalles</button>
          </form>
	        <form class="" action="/php/verificar_disponibilidad.php" method="post">
            <input type="hidden" name="trip_id" value="<?= $trip["id_viaje"]; ?>">
            <?php
              if (alreadyHaveRequest($conn, $_SESSION["user_id"], $trip["id_viaje"])){ 
                $query = "SELECT * FROM solicitud WHERE id_viaje=".$trip["id_viaje"]." AND id_pasajero=".$_SESSION["user_id"];
                $request = mysqli_fetch_assoc(mysqli_query($conn, $query));
                switch($request["estado"]){
                  case PENDING: echo '<button class="btn btn-warning" disabled>Asiento solicitado</button>';
                    break;
                  case ACCEPTED: echo '<button class="btn btn-success" disabled>Solicitud aceptada!</button>';
                    break;
                  case REJECTED: echo '<button class="btn btn-danger" disabled>Solicitud rechazada</button>';
                    break;
                }
              } else {
                ?> <button class="btn btn-success">Solicitar asiento</button> <?
              }
            ?> 
          </form>
        </div>
      </div>

      <?php

              $trip = mysqli_fetch_assoc($result);
            }
          } else {
            echo "<h2>No hay ningun viaje registrado!</h2><br>";
          }
        } else {
          echo "Hubo un error al conectarse con la base de datos. <br> Por favor, intentelo nuevamente mas tarde.";
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
  <script src="/js/listar_viajes.js"></script>
  <?php
    get_success("sol_success", "Solicitud realizada con exito");
    get_error("no_card", "¡No posee tarjetas para poder realizar una solicitud!");
    get_error("has_one", "Ya tienes una solicitud para este viaje");
    get_error("pending_califications", "¡Posee calificaciones de hace mas de 30 dias!, realicelas para postularse a un viaje");
    get_error("date_error", "¡Ya tiene un viaje que coincide con esa fecha!");
    get_error("db_error", "Ha ocurrido un error en la conexión, intentelo mas tarde");
  ?>
</html>

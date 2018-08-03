<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");
  if(dbOcurrences($conn, "SELECT * FROM solicitud WHERE id_pasajero='".$_SESSION["user_id"]."'") == 0){
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
    <link href="/css/listar_solicitudes.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php include("header.php"); ?>
    <div id="body">
      <h1>Solicitudes realizadas</h1>
      Ver: <select name="filter" onchange="location = this.value">
        <option value="?state=all" <?= (isset($_GET["state"]) && ($_GET["state"]=="all"))?"selected":"" ?>>Todas</option>
        <option value="?state=0" <?= (isset($_GET["state"]) && ($_GET["state"]=="0"))?"selected":"" ?>>Pendientes</option>
        <option value="?state=1" <?= (isset($_GET["state"]) && ($_GET["state"]=="1"))?"selected":"" ?>>Aceptadas</option>
        <option value="?state=2" <?= (isset($_GET["state"]) && ($_GET["state"]=="2"))?"selected":"" ?>>Rechazadas</option>
      </select>
      
      <?php
        $request_number = 0;       
        $query = "SELECT * FROM solicitud WHERE id_pasajero='".$_SESSION["user_id"]."'";
        if(isset($_GET["state"])){
          if($_GET["state"] != "all"){
                  $query .= "AND estado=".$_GET["state"];
                }
        }
              $result1 = mysqli_query($conn, $query);
              if(!$result1){
                echo "<h2>Ocurrió un error al conectarse a la base de datos, por favor, intentelo mas tarde.</h2>";
              } else {
                $request_number += mysqli_num_rows($result1);
                while($request = mysqli_fetch_assoc($result1)){
                  $trip = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM viajes WHERE id_viaje='".$request["id_viaje"]."'"));
                  
      ?>
      <div class="vehicle">
        <div class="vehicle-info">
          
          <?php
            if($request["estado"] == PENDING){
          ?>
          <h3><?= $trip["origen"]." --> ".$trip["destino"] ?></h3>
          <button class="state btn btn-warning">Pendiente</button>
          <br>
          Fecha: <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?>
          <br>
          <?php if($request["comentario"] != ""){?>Comentario: <strong><?=  $request["comentario"]?></strong><?php } ?>
          <br>
          <form class="" action="/vistas/ver_detalles_viaje.php" method="post">
              <input type="hidden" name="trip_id" value="<?= $trip["id_viaje"]; ?>">
              <button class="btn btn-primary" name="">Ver detalles</button>
          </form> 
          <?php
           if(isPendingTrip($conn, $trip)){
          ?>
      	  <form id="delete-request" action="/php/baja_solicitud_propia.php" method="post">
            <input type="hidden" name="request_id" value="<?= $request["id_solicitud"] ?>">
            <button class="action btn btn-danger delete_card" name="">Cancelarla</button>
          </form>
          <?php
            }
            } else if($request["estado"] == ACCEPTED){
          ?>
          <h3><?= $trip["origen"]." --> ".$trip["destino"] ?></h3>
          <button class="state btn btn-success">Aceptada</button>
          <br>
          Fecha: <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?>
          <br>
          <?php if($request["comentario"] != ""){?>Comentario: <strong><?=  $request["comentario"]?></strong><?php } ?>
          <br>
          <form class="" action="/vistas/ver_detalles_viaje.php" method="post">
              <input type="hidden" name="trip_id" value="<?= $trip["id_viaje"]; ?>">
              <button class="btn btn-primary" name="">Ver detalles</button>
          </form> 
          <?php
           if(isPendingTrip($conn, $trip)){
          ?>
          <form id="delete-request-accept" action="/php/baja_solicitud_propia_aceptada.php" method="post">
            <input type="hidden" name="request_id" value="<?= $request["id_solicitud"] ?>">
            <button class="action btn btn-danger delete_card" name="">Cancelarla</button>
          </form>
          <?php
            }
            } else if($request["estado"] == REJECTED){
          ?>
          <h3><?= $trip["origen"]." --> ".$trip["destino"] ?></h3>
          <button class="state btn btn-danger">Rechazada</button>
          <br>
          Fecha: <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?>
          <br>
          <?php if($request["comentario"] != ""){?>Comentario: <strong><?=  $request["comentario"]?></strong><?php } ?>
          <br>
          <form class="" action="/vistas/ver_detalles_viaje.php" method="post">
              <input type="hidden" name="trip_id" value="<?= $trip["id_viaje"]; ?>">
              <button class="btn btn-primary" name="">Ver detalles</button>
          </form> 



          <?php
            }
          ?>
        </div>
      </div>
      <?php
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
  <script src="/js/ver_solicitudes.js"></script>
   <?php 
      get_success("deleted_success", "La solicitud ha sido eliminada.");
      get_error("deleted_error", "La solicitud no se pudo eliminar.");
      get_error("notification_error_cancel", "Error al enviar el correo de cancelación");
   ?>
</html>
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
    <link href="/css/listar_solicitudes.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php include("header.php"); ?>
    <div id="body">
      <h1>Solicitudes de viaje</h1>
      Ver: <select name="filter" onchange="location = this.value">
        <option value="?state=all&trip_id=<?= $_GET['trip_id'] ?>" <?= (isset($_GET["state"]) && ($_GET["state"]=="all"))?"selected":"" ?>>Todas</option>
        <option value="?state=0&trip_id=<?= $_GET['trip_id'] ?>" <?= (isset($_GET["state"]) && ($_GET["state"]=="0"))?"selected":"" ?>>Pendientes</option>
        <option value="?state=1&trip_id=<?= $_GET['trip_id'] ?>" <?= (isset($_GET["state"]) && ($_GET["state"]=="1"))?"selected":"" ?>>Aceptadas</option>
        <option value="?state=2&trip_id=<?= $_GET['trip_id'] ?>" <?= (isset($_GET["state"]) && ($_GET["state"]=="2"))?"selected":"" ?>>Rechazadas</option>
      </select>
      <?php
        $request_number = 0;
        $query = "SELECT * FROM viajes WHERE id_viaje='".$_GET["trip_id"]."'";
        $result = mysqli_query($conn, $query);
        if(!$result){
          echo "<h2>Ocurrió un error al conectarse a la base de datos, por favor, intentelo mas tarde.</h2>";
        } else {
          while($trip = mysqli_fetch_assoc($result)){
            if(isPendingTrip($conn, $trip)){
              $trip_id = $trip["id_viaje"];
              $query = "SELECT * FROM solicitud WHERE id_viaje='$trip_id'";
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
                  $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='".$request["id_pasajero"]."'"));
                  
      ?>
      <div class="vehicle">
        <div class="vehicle-info">
          <?php
            if($request["estado"] == PENDING){
          ?>
          <h3><?= $user["nombre"]." ".$user["apellido"] ?></h3>
          <h3><span class="badge badge-pill badge-warning">Pendiente</span></h3>
          <br>
          Fecha: <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?>
          <br>
          <?php if($request["comentario"] != ""){?>Comentario: <strong><?=  $request["comentario"]?></strong><?php } ?>
          <br>
          <a class="action btn btn-primary" href="/vistas/ver_viaje.php?id=<?= $trip["id_viaje"]?>">Ver viaje</a>
      	  <form class="" action="/php/aceptar_solicitud.php" method="post">
            <input type="hidden" name="request_id" value="<?= $request["id_solicitud"] ?>">
            <button class="action btn btn-success" name="">Aceptar</button>
          </form>
	        <form class="" action="/php/cancelar_solicitud.php" method="post">
            <input type="hidden" name="request_id" value="<?= $request["id_solicitud"] ?>">
            <button class="action btn btn-danger delete_card" name="">Rechazar</button>
          </form>
          <?php
            } else if($request["estado"] == ACCEPTED){
          ?>
          <h3><?= $user["nombre"]." ".$user["apellido"] ?></h3>
          <h3><span class="badge badge-pill badge-success">Aceptada</span></h3>
          <br>
          Fecha: <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?>
          <br>
          <?php if($request["comentario"] != ""){?>Comentario: <strong><?=  $request["comentario"]?></strong><?php } ?>
          <br>
          <a class="action btn btn-primary" href="/vistas/ver_viaje.php?id=<?= $trip["id_viaje"]?>">Ver viaje</a>
      	  <form id="delete-request" action="/php/baja_solicitud.php" method="post">
            <input type="hidden" name="request_id" value="<?= $request["id_solicitud"] ?>">
            <button class="action btn btn-danger delete_card" name="">Rechazar</button>
          </form>
          <?php
            } else if($request["estado"] == REJECTED){
          ?>
          <h3><?= $user["nombre"]." ".$user["apellido"] ?></h3>
          <h3><span class="badge badge-pill badge-danger">Rechazada</span></h3>
          <br>
          Fecha: <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?>
          <br>
          <?php if($request["comentario"] != ""){?>Comentario: <strong><?=  $request["comentario"]?></strong><?php } ?>
          <br>
          <a class="action btn btn-primary" href="/vistas/ver_viaje.php?id=<?= $trip["id_viaje"]?>">Ver viaje</a>
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
    get_success("rejected_success", "La solicitud ha sido rechazada.");
    get_success("success_accepted", "La solicitud ha sido aceptada exitosamente.");
    get_error("deleted_error", "La solicitud no se pudo eliminar.");
    get_error("notification_error", "Error al enviar el correo de confirmación");
    get_error("notification_error_cancel", "Error al enviar el correo de cancelación");
    get_error("no_seats", "¡No hay mas asientos disponibles para este viaje!");
     ?>

</html>

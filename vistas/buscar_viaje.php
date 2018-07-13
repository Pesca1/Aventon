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

      $user_id = $_SESSION["user_id"];
      $query = "SELECT * from viajes WHERE id_usuario!=$user_id";
      if(isset($_POST["date"]) && $_POST["date"]!=""){
        $query .= " AND CAST(fecha_hora as DATE)='".$_POST["date"]."'";
      }
      if(isset($_POST["origin"]) && $_POST["origin"]!=""){
        $query .= " AND origen='".$_POST["origin"]."'";
      }
      if(isset($_POST["destination"]) && $_POST["destination"]!=""){
        $query .= " AND destino='".$_POST["destination"]."'";
      }

      $result = mysqli_query($conn, $query);
    ?>
    <div id="body">
      <h1>Resultados de la búsqueda</h1>
      <?php
        while($trip = mysqli_fetch_assoc($result)){
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
      <?php } ?>
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

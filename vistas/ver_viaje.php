<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");

  if(isset($_GET["id"]) && ($_GET["id"] != "")){
    if(dbOcurrences($conn, "SELECT * FROM viajes WHERE id_viaje='".$_GET["id"]."' AND id_usuario='".$_SESSION["user_id"]."'") == 0){
      header("Location: /vistas/ver_viajes.php");
    }
  } else {
    header("Location: /vistas/ver_viajes.php");
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
      $trip_id = $_GET["id"];
      $query = "SELECT * FROM viajes WHERE id_viaje='$trip_id'";
      $result = mysqli_query($conn, $query);
      $trip = mysqli_fetch_assoc($result);
      $query = "SELECT * FROM vehiculo WHERE patente='".$trip["patente"]."'";
      $result = mysqli_query($conn, $query);
      $car = mysqli_fetch_assoc($result);
      $query = "SELECT * FROM solicitud WHERE id_viaje='$trip_id' AND estado=".ACCEPTED;
      $requests = mysqli_query($conn, $query);
      $n_request = mysqli_num_rows($requests);
      $remaining_seats = $car["asientos"] - $n_request;
      $price = $trip["costo"]/($n_request+1);
    ?>
    <div id="body">
      <h1>Viaje <?= $trip["origen"]." --> ".$trip["destino"] ?></h1>
      <div id="trip_info">
        Fecha y hora: <?= $trip["fecha_hora"] ?>
        <br>
        Duración: <?= printTime($trip["duracion"]) ?>
        <br>
        Vehículo: <?= $car["marca"]." ".$car["modelo"] ?>
        <br>
        Costo por persona: $<?= $price ?>
      </div>
      <div id="passengers">
        <?php
          if($n_request == 0){
            echo "No hay pasajeros todavía.";
          } else {
            while($request = mysqli_fetch_assoc($requests)){
              $query = "SELECT * FROM usuario WHERE id_usuario='".$request["id_pasajero"]."'";
              $passenger = mysqli_fetch_assoc(mysqli_query($conn, $query));
              echo $passenger["nombre"]." ".$passenger["apellido"]."<br>";
            }
          }
        ?>
      </div>
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


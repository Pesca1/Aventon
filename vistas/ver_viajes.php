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
      <h1>Mis viajes</h1>
      <?php
        $id = $_SESSION["user_id"];
        $sql = "SELECT * FROM viajes WHERE id_usuario='$id'";
        $result = mysqli_query($conn, $sql);
        if($result){
          if($trip = mysqli_fetch_assoc($result)){
            while($trip){?>
          
      <div class="vehicle">
        <div class="vehicle-info">
          <h3><?= $trip["origen"] ?> --> <?= $trip["destino"] ?></h3>
          <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?> - Duración:
          <?php
            $hours = floor($trip["duracion"]);
            $minutes = $trip["duracion"]-$hours;
            if($hours > 0){
              echo $hours.(($hours>=2)?" horas":" hora");
              if($minutes > 0){
                echo " y";
              }
            }
            if($minutes > 0){
              echo " ".($minutes*60)." minutos";
            }
            echo ".";
          ?>
	  <br>
          <br>
	  <form class="" action="/vistas/editar_viaje.php" method="post">
            <input type="hidden" name="trip_id" value="<?= $trip["id"]; ?>">
            <button class="btn" name="">Modificar Viaje</button>
          </form>
	  <form class="" action="/php/baja_viaje.php" method="post">
            <input type="hidden" name="trip_id" value="<?= $trip["id_viaje"]; ?>">
            <button class="btn btn-danger delete_trip" name="">Cancelar viaje</button>
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
      <button class="btn btn-success"><a href="/vistas/registrar_viaje.php">Crear Viaje</a></button>
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
    get_success("vehicle_removed_with_average", "Vehículo eliminado exitosamente y puntaje actualizado");
    get_success("vehicle_removed", "Vehículo eliminado exitosamente");
    get_error("no_car", "Debe registrar un auto para poder crear un viaje!");
    get_error("no_card", "Debe registrar una tarjeta para poder crear un viaje!");
    get_error("pending_califications", "Tiene una calificación pendiente, por favor, califique al usuario antes de crear otro viaje.");
  ?>
</html>

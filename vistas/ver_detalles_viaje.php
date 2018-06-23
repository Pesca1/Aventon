<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8"/>
    <title>Aventón</title>
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <link href="/css/index.css" rel="stylesheet" type="text/css">
    <link href="/css/ver_viaje.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php
      include("header.php");
      $trip_id = $_POST["trip_id"];
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
      $price = $trip["costo"];
    ?>
    <div id="body">
      <h1>Viaje <?= $trip["origen"]." --> ".$trip["destino"] ?></h1>
      <div id="trip_info">
        <h3>Información</h3>
        Fecha y hora: <?= $trip["fecha_hora"] ?>
        <br>
        Duración: <?= printTime($trip["duracion"]) ?>
        <br>
        Vehículo: <?= $car["marca"]." ".$car["modelo"] ?>
        <br>
        Tipo de viaje: <?= $trip["tipo"] ?>
        <br>
        Costo por persona: $<?= round($price) ?>
        <?php if($trip["descripcion"] != ""){ ?>
        <br>
        Descripción: 
        <div id="trip-description">
          <?= $trip["descripcion"] ?>
        </div>
        <?php } ?>
      </div>
      <div id="passengers">
        <h3>Conductor</h3>
        <?php
          $query = "SELECT * FROM usuario WHERE id_usuario='".$trip["id_usuario"]."'";
          $passenger = mysqli_fetch_assoc(mysqli_query($conn, $query));
          echo "<div class='user'><div class='info'>";
          echo "<strong>".$passenger["nombre"]." ".$passenger["apellido"];
          echo "</strong><br>".$passenger["mail"];
          echo "</div><img src='/img/profile_users/".$passenger["foto_perfil"]."' class='profile_picture'/><br>";
          echo "</div>";
        ?>
	      <form class="" action="/php/verificar_disponibilidad.php" method="post">
          <input type="hidden" name="trip_id" value="<?= $trip["id_viaje"]; ?>">
          <button class="btn btn-success" name="" <?php if (alreadyHaveRequest($conn, $_SESSION["user_id"], $trip["id_viaje"])){ echo "disabled > Asiento solicitado </button>"; }else{ echo ">Solicitar asiento</button>";} ?> 
        </form>
      </div>
      <div id="questions">
        <h3>Preguntas y Respuestas</h3>
        <?php
          $query = "SELECT * FROM pregunta WHERE id_viaje='$trip_id'";
          $questions = mysqli_query($conn, $query);
          if(mysqli_num_rows($questions) == 0){
            echo "Aún no hay preguntas para este viaje.";
          } else {
            while($question = mysqli_fetch_assoc($questions)){
              $query = "SELECT * FROM usuario WHERE id_usuario='".$question["id_usuario"]."'";
              $user = mysqli_fetch_assoc(mysqli_query($conn, $query));
              ?>

        <div class="question">
          <strong><?= $user["nombre"]." ".$user["apellido"] ?></strong>
           preguntó:<br>
           - <?= $question["texto"]?>
           <br>
           <?php if($question["respuesta"] == ""){ ?>
           <strong>Sin responder aún</strong>
           <?php 
             } else {
           ?>
           Respondiste:<br>
           - <?= $question["respuesta"] ?>
           <?php
             }
           ?>
        </div>

              <?php
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


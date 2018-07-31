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

      (isset($_POST["trip_id"]))? $trip_id = $_POST["trip_id"] : $trip_id = $_GET["trip_id"];
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
        Fecha y hora: <?= formatDate($trip["fecha_hora"]) ?>
        <br>
        Duración: <?= printTime($trip["duracion"]) ?>
        <br>
        Vehículo: <?= $car["marca"]." ".$car["modelo"] ?>
        <br>
        Tipo de viaje: <?= ($trip["tipo"] == ONE_TIME_TRIP?"Ocasional":"Semanal") ?>
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
              include("_comment_passenger.php");
            }
          }
        ?>
      </div>
      <?php
        if($trip["tipo"]==WEEKLY_TRIP){
          echo "<div id='dates'><h3>Fechas</h3><table>";
          $query = "SELECT * FROM viaje_semanal WHERE id_viaje=$trip_id";
          $dates = mysqli_query($conn, $query);
          while($date = mysqli_fetch_assoc($dates)){
            $obj = new DateTime($date["fecha_hora"]);
            $weekDay = $days[$obj->format("N")];
            echo "<tr><td> - ".$weekDay." ".$obj->format("d/m")."</td></tr>";
          }
          echo "</table></div>";
        }
       ?>
      <div id="questions">
        <form action="/php/enviar_pregunta.php" method="post">
          <h4>Haga una pregunta:</h4>
          <input type="hidden" value="<?= $trip_id ?>" name="trip_id">
          <textarea class="form-control" name="question" rows="5" cols="20" wrap="hard" style="resize: none" required="required" ></textarea><br>
          <button type="submit" class="btn btn-success">Enviar comentario</button>
        </form>
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


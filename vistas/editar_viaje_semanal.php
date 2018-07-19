<!DOCTYPE html>
<html>
  <head>
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <link href="/css/index.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php
      include("../php/verficar_sesion.php");
      include("../php/abrir_conexion.php");
      include("../php/utils.php");
      include("header.php");
      if(hasOldCalifications($conn, $_SESSION["user_id"])) {
        header("Location: /vistas/ver_viajes.php?pending_califications");
        exit();
      } else if(dbOcurrences($conn, "SELECT * FROM solicitud WHERE id_viaje=".$_POST["trip_id"]) > 0){
        header("Location: /vistas/ver_viajes.php?has_requests");
        exit();
      }
      $trip_id = $_POST['trip_id'];
      $query = "SELECT * FROM viajes WHERE id_viaje='".$trip_id."tr'";
      $result = mysqli_query($conn, $query);
      $trip = mysqli_fetch_assoc($result);
      $register = $trip["patente"];
      $query = "SELECT * FROM vehiculo WHERE patente='$register'";
      $result = mysqli_query($conn, $query);
      $car = mysqli_fetch_assoc($result);
    ?>
    <div id="body">
      <h3>Editar viaje semanal: <?= $trip["origen"] ?> --> <?= $trip["destino"] ?></h3>
      <form action="/php/editar_viaje_semanal.php" id="trip_reg" method="post" autocomplete="off">
        <input name="trip_id" type="hidden" value="<?= $trip["id_viaje"] ?>">
          <label for="" class="form-check-label">Vehículo:</label><br><br>
      <?php
          $query = "SELECT * FROM vehiculo WHERE id_usuario='".$_SESSION["user_id"]."'";
          $result = $conn->query($query);
          
          if($result){
            while($vehicle = mysqli_fetch_assoc($result)){
              ?>
            
          <input class="form-check-input" type="radio" name="car_plate" value="<?= $vehicle["patente"] ?>" <?php if ($vehicle["patente"] == $car["patente"]) echo "checked" ?> required="required"/>
          <?php echo($vehicle["marca"]." ".$vehicle["modelo"]) ?>
          <br>
        
              <?php
            }
          }
        ?><br><br><br>
        <div class="form-row">
          <div class="form-group col-md-4">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Origen:</span>
              </div>
              <input type="text" class="form-control" name="origin" required="required" value="<?= $trip['origen'] ?>">
            </div>         
          </div>
          <div class="form-group col-md-4">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Destino:</span>
              </div>
              <input type="text" class="form-control" name="destination" required="required" value="<?= $trip['destino'] ?>">
            </div> 
          </div>
        </div>
        <?php
            $trip_day = date("d", strtotime($trip["fecha_hora"]));
            $trip_month = date("m", strtotime($trip["fecha_hora"]));
            $trip_hour = date("H", strtotime($trip["fecha_hora"]));
            $trip_minute = date("i", strtotime($trip["fecha_hora"]));
            $trip_hour_minuete = $trip_hour.":".$trip_minute;
            $duration_hours = floor($trip['duracion']);
            $duration_minutes = $trip['duracion'] - $duration_hours;
            if($duration_minutes > 0){
              $duration_minutes = $duration_minutes * 60;
            }
          ?>
        Duración:
        <div class="form-row">
          <div class="form-group col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Horas:</span>
              </div>
              <input type="number" min="0" value="<?= $duration_hours ?>" class="form-control" name="duration_hours" required="required">
            </div> 
          </div>
          <div class="form-group col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Minutos:</span>
              </div>
              <input type="number" min="0" max="59" value="<?= $duration_minutes ?>" class="form-control" name="duration_minutes" required="required">
            </div>
          </div>
          <div class="form-group col-md-4">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Costo por persona ($)</span>
              </div>
              <input id="price" type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" required="required" value="<?= floatval($trip['costo']) ?>">
            </div>
          </div>
          
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
          <?php
             $query = "SELECT * FROM viaje_semanal WHERE id_viaje='$trip_id'";
             $result = mysqli_query($conn, $query);
             $daysToTrip = daysOfTrips($result);
            ?>
            <label for="destination">Días</label> <br>
            <label><input class="day" type="checkbox" name="monday" <?= (in_array(1, $daysToTrip))? "checked":"" ?> />  Lunes</label><br>
            <label><input class="day" type="checkbox" name="tuesday"<?= (in_array(2, $daysToTrip))? "checked":"" ?> />  Martes</label><br>
            <label><input class="day" type="checkbox" name="wednesday"<?= (in_array(3, $daysToTrip))? "checked":"" ?> />  Miércoles</label><br>
            <label><input class="day" type="checkbox" name="thursday" <?= (in_array(4, $daysToTrip))? "checked": "" ?> />  Jueves</label><br>
            <label><input class="day" type="checkbox" name="friday" <?= (in_array(5, $daysToTrip))? "checked": "" ?> />  Viernes</label><br>
            <label><input class="day" type="checkbox" name="saturday" <?= (in_array(6, $daysToTrip))? "checked": "" ?> />  Sabado</label><br>
            <label><input class="day" type="checkbox" name="sunday" <?= (in_array(7, $daysToTrip))? "checked": "" ?> />  Domingo</label>
          </div>
          <div class="form-group col-md-4">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Semanas a repetir</span>
                <input class="form-control" type="number" max="4" min="1" name="weeks" value="1"/>
              </div>
            </div>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Hora</span>
                <input class="form-control" type="time" name="time" required="required" value="12:00"/>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="description" >Descripción:</label><br>
            <textarea class="form-control" name="description" rows="5" cols="30" wrap="hard" style="resize: none" placeholder="¿Algo para agregar?" > <?= $trip['descripcion'] ?> </textarea>
          </div>    
          <div class="form-group col-md-4">
            <label for="credit_card">Tarjeta:</label>
            <?php
              $card_id = $trip["tarjeta"];
              $query = "SELECT * FROM tarjetas WHERE id_usuario='".$_SESSION["user_id"]."'";
              $result = mysqli_query($conn, $query);
              if($result){
                while($card = mysqli_fetch_assoc($result)){
            ?>
            <div class="option">
              <input type="radio" name="card" value="<?= $card["numero"] ?>" required="required" <?php if ($card_id == $card["numero"]) echo "checked" ?>/>
              Código: <?= formatCard($card["numero"]) ?> <br> Vencimiento: <?= (new DateTime($card["vencimiento"]))->format("m/Y") ?>
            </div>
            <?php
                }
              }
            ?>
          </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Guardar" id="submit"/>
      </form>
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
  <script src="/js/registrar_viaje_semanal.js"></script>
</html>

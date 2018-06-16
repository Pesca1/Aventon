<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");

if(hasOldCalifications($conn, $_SESSION["user_id"])) {
    header("Location: /vistas/ver_viajes.php?pending_califications");
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
<!DOCTYPE html>
<html>
  <head> 
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <link href="/css/index.css" rel="stylesheet" type="text/css">
    <link href="/css/listar_vehiculos.css" rel="stylesheet" type="text/css">
  </head>
  <body> 
    <?php
      include("header.php");
    ?><br><br>
    <div class="container">
      <h3>Editar viaje: <?= $trip["origen"] ?> --> <?= $trip["destino"] ?> del <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?></h3>
      <form action="/php/editar_viaje.php?edit=true" method="post" autocomplete="off">
        <input name="trip_id" type="hidden" value="<?= $trip["id_viaje"] ?>"
      <?php
          $query = "SELECT * FROM vehiculo WHERE id_usuario='".$_SESSION["user_id"]."'";
          $result = mysqli_query($conn, $query);

          if($result){
            while($vehicle = mysqli_fetch_assoc($result)){
              ?>
            
          <label for="" class="form-check-label">Vehículo:</label><br><br>
          <input class="form-check-input" type="radio" name="car_plate" value="<?php $vehicle["patente"] ?>" <?php if ($vehicle["patente"] == $car["patente"]) echo "checked" ?>/>
          <?php echo($vehicle["marca"]." ".$vehicle["modelo"]) ?>
        
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
              <input type="text" class="form-control" name="origin" required="required" value="<?php echo $trip['origen']; ?>">
            </div>         
          </div>
          <div class="form-group col-md-4">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Destino:</span>
              </div>
              <input type="text" class="form-control" name="destination" required="required" value="<?php echo $trip['destino']; ?>">
            </div> 
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-4">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Duración (en horas):</span>
              </div>
              <input type="text" class="form-control" name="duration" required="required" value="<?php echo $trip['duracion']; ?>">
            </div> 
          </div>

          <?php
            $trip_day = date("d", strtotime($trip["fecha_hora"]));
            $trip_month = date("m", strtotime($trip["fecha_hora"]));
            $trip_hour = date("H", strtotime($trip["fecha_hora"]));
            $trip_minute = date("i", strtotime($trip["fecha_hora"]));
          ?>


          <div class="form-group col-md-4">
            <label for="destination">Fecha y hora</label> <br>
            Día:
            <select name="day" id="day">
              <?php
                for($i = 1; $i <= 31; $i++){
                  if ($trip_day == $i){
                    echo "<option selected>$i</option>";
                  }
                  echo "<option>$i</option>";
                }
                ?>
            </select>
            - Mes:
            <select name="month" id="month">
              <?php
                for($i = intval(date("n")); $i <= intval(date("n"))+1; $i++){
                  if ($trip_month == $i){
                    echo "<option selected>$i</option>";
                  }
                  echo "<option>$i</option>";
                }
                ?>
            </select>
            - Hora:
              <input type="time" name="time" value="12:00" required="required"/>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-4">
            <br>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <label class="input-group-text" name="type">Tipo de viaje</label>
              </div>
              <select class="custom-select" id="type" name="type">
                <option> Seleccione una opción</option>
                <option <?php if ($trip['tipo'] == "Ocasional") echo " selected"?>>Ocasional</option>
                <option <?php if ($trip['tipo'] == "Diario") echo " selected"?>>Diario</option>
                <option <?php if ($trip['tipo'] == "Semanal") echo " selected"?>>Semanal</option>
              </select>
            </div>
          </div>

          <div class="form-group col-md-4"><br>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Costo (en pesos)</span>
              </div>
              <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" required="required" value="<?php echo $trip['costo']; ?>">
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="credit_card">Tarjeta:</label>
            <?php
              $query = "SELECT * FROM tarjetas WHERE id_usuario='".$_SESSION["user_id"]."'";
              $result = mysqli_query($conn, $query);
              
              $card_id = $trip["tarjeta"];
              $query2 = "SELECT * FROM tarjetas WHERE numero='$card_id'";
              $result2 = mysqli_query($conn, $query2);
              $trip_card = mysqli_fetch_assoc($result2);

              if($result){
                while($card = mysqli_fetch_assoc($result)){
            ?>
            <div class="option">
              <input type="radio" name="card" value="<?= $card["numero"] ?>" required="required" <?php if ($trip_card["numero"] == $card["numero"]) echo "checked" ?> />
              Código: <?= $card["numero"] ?>
            </div>
            <?php
                }
              }
            ?>
          </div>
          <div class="form-group col-md-4">
            <label for="description" >Descripción:</label><br>
            <textarea class="form-control" name="description" rows="5" cols="30" wrap="hard" style="resize: none" ><?php echo $trip['descripcion']; ?></textarea>
          </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Guardar" id="submit"/>        
      </form>
    </div>    


  </body>
  <?php 
    include("bootstrap.php"); 
    include("../php/cerrar_conexion.php");
  ?>
  <script src="/js/registrar_usuario.js"></script>
  <script src="/js/registrar_viaje.js"></script>
  </html>
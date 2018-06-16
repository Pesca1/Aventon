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
      <form action="/php/editar_viaje.php?edit=true" method="post">
        <input name="trip_id" type="hidden" value="<?= $trip["id_viaje"] ?>"
      <?php
          $query = "SELECT * FROM vehiculo WHERE id_usuario='".$_SESSION["user_id"]."'";
          $result = $conn->query($query);
          
          if($result){
            while($vehicle = mysqli_fetch_assoc($result)){
              ?>
            
          <label for="" class="form-check-label">Vehículo:</label><br><br>
          <input class="form-check-input" type="radio" name="car_plate" value="<?php $vehicle["patente"] ?>" required="required"/>
          <?php echo($vehicle["marca"]." ".$vehicle["modelo"]) ?>
        
              <?php
            }
          }
        ?><br><br><br>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="origin">Origen</label>
            <input type="text"class="form-control" name="origin" required="required" value="<?php echo $trip['origen']; ?>">
          </div>
          <div class="form-group col-md-6">
            <label for="destination">Destino</label>
            <input type="text"class="form-control" name="destination" required="required" value="<?php echo $trip['destino']; ?>">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="duration">Duración (en horas)</label>
            <input type="text"class="form-control" name="duration" required="required" value="<?php echo $trip['duracion']; ?>">
          </div>
          <div class="form-group col-md-6">
            <label for="destination">Fecha y hora</label> <br>
            Día:
            <select name="day" id="day">
              <?php
                for($i = 1; $i <= 31; $i++){
                  echo "<option>$i</option>";
                }
              ?>
            </select>
            - Mes:
            <select name="month" id="month">
              <?php
                for($i = intval(date("n")); $i <= intval(date("n"))+1; $i++){
                  echo "<option>$i</option>";
                }
              ?>
            </select>
            - Hora:
            <input type="time" name="time" value="12:00" required="required"/>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="type">Tipo de viaje</label>
            <input type="text"class="form-control" name="type" required="required" value="<?php echo $trip['tipo']; ?>">
          </div>
          <div class="form-group col-md-6">
            <label for="price">Costo (en pesos)</label>
            <input type="text"class="form-control" name="price" required="required" value="<?php echo $trip['costo']; ?>">
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="credit_card">Tarjeta:</label>
            <?php
              $query = "SELECT * FROM tarjetas WHERE id_usuario='".$_SESSION["user_id"]."'";
              $result = mysqli_query($conn, $query);
              if($result){
                while($card = mysqli_fetch_assoc($result)){
            ?>
            <div class="option">
              <input type="radio" name="card" value="<?= $card["numero"] ?>" required="required"/>
              Código: <?= $card["numero"] ?>
            </div>
            <?php
                }
              }
            ?>
          </div>
          <div class="form-group col-md-6">
            <label for="description" >Descripción:</label><br>
            <textarea name="description" rows="5" cols="30" wrap="hard" style="resize: none" value="<?php echo $trip['descripcion']; ?>"></textarea>
          </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Registrar" id="submit"/>        
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
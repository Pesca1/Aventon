<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");

  if(dbOcurrences($conn, "SELECT * FROM vehiculo WHERE id_usuario='".$_SESSION["user_id"]."'") == 0){
    header("Location: /vistas/ver_viajes.php?no_car");
  } else if(dbOcurrences($conn, "SELECT * FROM tarjetas WHERE id_usuario='".$_SESSION["user_id"]."'") == 0){
    header("Location: /vistas/ver_viajes.php?no_card");
  } else if(hasOldCalifications($conn, $_SESSION["user_id"])) {
    header("Location: /vistas/ver_viajes.php?pending_califications");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <link href="/css/index.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php
      include("header.php");
    ?>
    <div id="body">
      <h1>Nuevo viaje</h1>
      <form method="post" action="/php/alta_viaje.php" id="trip_reg" autocomplete="off">
          <label for="" class="form-check-label">Vehículo:</label><br><br>
      <?php
          $query = "SELECT * FROM vehiculo WHERE id_usuario='".$_SESSION["user_id"]."'";
          $result = $conn->query($query);
          
          if($result){
            while($vehicle = mysqli_fetch_assoc($result)){
              ?>
            
          <input class="form-check-input" type="radio" name="car_plate" value="<?= $vehicle["patente"] ?>" required="required"/>
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
              <input type="text" class="form-control" name="origin" required="required">
            </div>         
          </div>
          <div class="form-group col-md-4">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Destino:</span>
              </div>
              <input type="text" class="form-control" name="destination" required="required">
            </div> 
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-4">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Duración (horas):</span>
              </div>
              <input type="number" min="0" value="0" class="form-control" name="duration_hours" required="required">
            </div> 
           </div>

          <div class="form-group col-md-4">
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
          <div class="form-group col-md-4">
            <br>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Duración (minutos):</span>
              </div>
              <input type="number" min="0" value="0" class="form-control" name="duration_minutes" required="required">
            </div>
          </div>

          <div class="form-group col-md-4"><br>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Costo ($)</span>
              </div>
              <input type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" required="required">
            </div>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="credit_card">Tarjeta:</label>
            <?php
              $query = "SELECT * FROM tarjetas WHERE id_usuario='".$_SESSION["user_id"]."'";
              $result = mysqli_query($conn, $query);
              if($result){
                while($card = mysqli_fetch_assoc($result)){
            ?>
            <div class="option">
              <input type="radio" name="card" value="<?= $card["numero"] ?>" required="required"/>
              Código: <?= $card["numero"] ?> <br> Vencimiento: <?= $card["vencimiento"] ?>
            </div>
            <?php
                }
              }
            ?>
          </div>
          <div class="form-group col-md-4">
            <label for="description" >Descripción:</label><br>
            <textarea class="form-control" name="description" rows="5" cols="30" wrap="hard" style="resize: none" placeholder="¿Algo para agregar?" ></textarea>
          </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Registrar" id="submit"/>
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
  <script src="/js/registrar_viaje.js"></script>
</html>

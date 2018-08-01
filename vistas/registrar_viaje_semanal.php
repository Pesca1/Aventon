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
    ?>
    <div id="body">
      <h1>Nuevo viaje recurrente</h1>
      <form method="post" action="/php/alta_viaje_semanal.php" id="trip_reg" autocomplete="off">
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
        Duración:
        <div class="form-row">
          <div class="form-group col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Horas:</span>
              </div>
              <input type="number" min="1"  value="0" class="form-control" name="duration_hours" required="required">
            </div> 
          </div>
          <div class="form-group col-md-2">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Minutos:</span>
              </div>
              <input type="number" min="0" max="59" value="0" class="form-control" name="duration_minutes" required="required">
            </div>
          </div>
          <div class="form-group col-md-4">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Costo por persona ($)</span>
              </div>
              <input id="price" type="text" class="form-control" aria-label="Amount (to the nearest dollar)" name="price" required="required">
            </div>
          </div>
          
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="destination">Días</label> <br>
            <label><input class="day" type="checkbox" name="monday" id="day1"/>  Lunes</label><br>
            <label><input class="day" type="checkbox" name="tuesday" id="day2"/>  Martes</label><br>
            <label><input class="day" type="checkbox" name="wednesday" id="day3"/>  Miércoles</label><br>
            <label><input class="day" type="checkbox" name="thursday" id="day4"/>  Jueves</label><br>
            <label><input class="day" type="checkbox" name="friday" id="day5"/>  Viernes</label><br>
            <label><input class="day" type="checkbox" name="saturday" id="day6"/>  Sabado</label><br>
            <label><input class="day" type="checkbox" name="sunday" id="day7"/>  Domingo</label>
          </div>
          <div class="form-group col-md-4">
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text">Semanas a repetir (incluyendo actual)</span>
                <input class="form-control" type="number" max="4" min="1" name="weeks" id="weeks" value="1"/>
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
            <textarea class="form-control" name="description" rows="5" cols="30" wrap="hard" style="resize: none" placeholder="¿Algo para agregar?" ></textarea>
          </div>    
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
              Código: <?= formatCard($card["numero"]) ?> <br> Vencimiento: <?= (new DateTime($card["vencimiento"]))->format("m/Y") ?>
            </div>
            <?php
                }
              }
            ?>
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
  <script src="/js/registrar_viaje_semanal.js"></script>
</html>

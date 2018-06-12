<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");

  if(dbOcurrences($conn, "SELECT * FROM vehiculo WHERE id_usuario='".$_SESSION["user_id"]."'") == 0){
    header("Location: /vistas/ver_viajes.php?no_car");
  }
  if(dbOcurrences($conn, "SELECT * FROM tarjetas WHERE id_usuario='".$_SESSION["user_id"]."'") == 0){
    header("Location: /vistas/ver_viajes.php?no_card");
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
      <form method="post" action="/php/alta_viaje.php" id="" autocomplete="off">
        <h3>Vehículo</h3>
        <?php
          $query = "SELECT * FROM vehiculo WHERE id_usuario='".$_SESSION["user_id"]."'";
          $result = mysqli_query($conn, $query);
          if($result){
            while($vehicle = mysqli_fetch_assoc($result)){
              ?>
        <div class="option">
          <input type="radio" name="car" value="<?= $vehicle["patente"] ?>" required="required"/>
          <?= $vehicle["marca"]." ".$vehicle["modelo"] ?>
        </div>
              <?php
            }
          }
        ?>
        <br>
        <h3>Origen</h3>
        <input type="text" name="origin" placeholder="Ciudad de origen" required="required"/>
        <br>
        <br>
        <h3>Destino</h3>
        <input type="text" name="destination" placeholder="Ciudad de Destino" required="required"/>
        <br>
        <br>
        <h3>Duración (en horas)</h3>
        <input type="text" name="duration" required="required"/> hs
        <br>
        <br>
        <h3>Fecha y hora</h3>
        Día:
        <select name="exp_day" id="day">
        <?php
          for($i = 1; $i <= 31; $i++){
            echo "<option>$i</option>";
          }
        ?>
        </select>
        - Mes:
        <select name="exp_month" id="month">
        <?php
          for($i = intval(date("n")); $i <= intval(date("n"))+1; $i++){
            echo "<option>$i</option>";
          }
        ?>
        </select>
        <?php
          if(intval(date("n")) == 12){
        ?>
        - Año:
        <select name="exp_year" id="year">
        <?php
          for($i = 2018; $i <= 2019; $i++){
            echo "<option>$i</option>";
          }
        ?>
        </select>
        <?php
          }
        ?>
        - Hora:
        <input type="time" name="time" value="12:00" required="required"/>
        <br>
        <br>
        <h3>Tipo de viaje</h3>
        <select name="type">
          <option>Ocasional</option>
          <option>Diario</option>
          <option>Semanal</option>
        </select>
        <br>
        <br>
        <h3>Costo (en pesos)</h3>
        <input type="number" name="price" required="required"/>
        <br>
        <br>
        <h3>Tarjeta</h3>
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
        <br>
        <br>
        <h3>Descripción</h3>
        <textarea name="description" rows="5" cols="30" wrap="hard" style="resize: none">¿Algo mas para decir?</textarea>
        <br>
        <br>
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
  <script src="/js/registrar_tarjeta.js"></script>
</html>

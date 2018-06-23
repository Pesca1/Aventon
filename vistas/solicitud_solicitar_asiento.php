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
      <div class="container">
        <form action="/php/alta_solicitud.php" method="post" autocomplete="off">
          <input type="hidden" name="trip_id" value="<?= $_GET['trip_id'] ?>">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="description" >Ingrese una observación para este viaje:</label><br>
              <textarea class="form-control" name="commentary" rows="5" cols="30" wrap="hard" style="resize: none" placeholder="¿Algo para agregar?" ></textarea>
            </div>            
            <div class="form-group col-md-4">
              <label for="credit_card">¿Con que tarjera va a pagar?:</label>
              <?php
                $query = "SELECT * FROM tarjetas WHERE id_usuario='".$_SESSION["user_id"]."'";
                $result = mysqli_query($conn, $query);
                if($result){
                  while($card = mysqli_fetch_assoc($result)){
                ?>
              <div class="option">
                <input type="radio" name="card" value="<?= $card["numero"] ?>" required="required"/>
                Código: <?= formatCard($card["numero"]) ?>
              </div>
              <?php
                  }
                }
              ?>
            </div>
          </div>
          <input type="submit" class="btn btn-primary" value="Realizar solicitud" id="submit"/>
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
  <script src="/js/listar_viajes.js"></script>
  <?php
    get_success("trip_removed_with_average", "Viaje eliminado exitósamente y puntaje actualizado");
    get_success("trip_removed", "Viaje eliminado exitósamente");
    get_error("card_expirated", "Esta tarjeta vencera antes de que el viaje se haga, por favor seleccione otra tarjeta");
  ?>
</html>

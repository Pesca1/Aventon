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
      <h1>Mis Tarjetas</h1>
      <?php
        $id = $_SESSION["user_id"];
        $sql = "SELECT * FROM tarjetas WHERE id_usuario='$id'";
        $result = mysqli_query($conn, $sql);
        if($result){
          if($card = mysqli_fetch_assoc($result)){
            while($card){?>
          
      <div class="vehicle">
        <div class="vehicle-info">
          <h3>Numero: <?= $card["numero"] ?></h3>
          Vencimiento: <?= $card["vencimiento"]?>
	  <br>
          <br>
	  <form class="" action="/vistas/editar_tarjeta.php" method="post">
            <input type="hidden" name="plate" value="<?= $card["numero"]; ?>">
            <button class="btn" name="">Modificar Información</button>
          </form>
	  <form class="" action="/php/baja_tarjeta.php" method="post">
            <input type="hidden" name="plate" value="<?= $card["numero"]; ?>">
            <button class="btn btn-danger delete_vehicle" name="">Eliminar</button>
          </form>
        </div>
      </div>

      <?php
              $card = mysqli_fetch_assoc($result);
            }
          } else {
            echo "<h2>No hay ninguna tarjeta registrada!</h2><br>";
          }
        } else {
          echo "Hubo un error al conectarse con la base de datos. <br> Por favor, intentelo nuevamente mas tarde.";
        }
      ?>
      <button class="btn btn-success"><a href="/vistas/registrar_tarjeta.php">Agregar tarjeta</a></button>
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
  <?php 
    get_success("reg_success", "Tarjeta registrada con éxito!");
    get_error("reg_error", "La tarjeta ya se encuentra registrada.");
    get_error("db_error", "Ocurrió un error, por favor, intentelo nuevamente mas tarde.");
  ?>
</html>

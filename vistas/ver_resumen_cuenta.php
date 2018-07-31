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

      $query= "SELECT * FROM transaccion WHERE id_usuario ='".$_SESSION['user_id']."' ";
      $result = mysqli_query($conn, $query);
    ?>
    <div id="body">
      <h1>Resumen de cuenta</h1>
      <?php
        if(mysqli_num_rows($result) == 0){
          echo "<h2>Todavía no realizó ningún viaje.</h2>";
        }
        while ($transaction = mysqli_fetch_assoc($result)){
          $q = "SELECT * FROM viajes WHERE id_viaje='".$transaction['id_viaje']."' ";
          $result2 = mysqli_query($conn, $q);
          $trip = mysqli_fetch_assoc($result2);
          ($transaction["tipo"] == PASSENGER)? include("_passenger_payment.php") : include("_collect_driver.php");
        }
      ?>
    </div>
  </body>

  <?php 
    include("bootstrap.php"); 
    include("../php/cerrar_conexion.php");
  ?>
  <script src="/js/registrar_usuario.js"></script>
  <script src="/js/listar_viajes.js"></script>
  <?php
    get_success("trip_removed_with_average", "Viaje eliminado exitósamente y puntaje actualizado");
    get_error("no_car", "Debe registrar un auto para poder crear un viaje!");
  ?>
</html>

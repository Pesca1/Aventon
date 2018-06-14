<!DOCTYPE html>
<html>
  <head>
    <title>Aventón</title>
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <link href="/css/index.css" rel="stylesheet" type="text/css">
    <link href="/css/listar_vehiculos.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php
      include("php/verficar_sesion.php");
      include("php/abrir_conexion.php");
      include("php/utils.php");
      include("vistas/header.php");
    ?>
    
    <div id="body">

    <?php

	  $card=$_POST['card_number'];

    $query = "DELETE FROM tarjetas WHERE numero='$card'";
    $result = mysqli_query($conn, $query);
    if($result){
      header("Location: /vistas/ver_tarjetas.php?deleted_success");
    } else {
      header("Location: /vistas/ver_tarjetas.php?deleted_error");
    }

    ?>

    </div>

    <?php
      include("vistas/footer.php");
    ?>
  </body>
  <?php 
    include("vistas/bootstrap.php"); 
    include("php/cerrar_conexion.php");
  ?>
  <script src="/js/registrar_usuario.js"></script>
</html>

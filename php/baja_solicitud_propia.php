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
      include("verficar_sesion.php");
      include("abrir_conexion.php");
      include("utils.php");
      include("../vistas/header.php");
    ?>
    
    <div id="body">

    <?php

    $request=$_POST['request_id'];

    $query = "DELETE FROM solicitud WHERE id_solicitud='$request'";
    $result = mysqli_query($conn, $query);
    if($result){
      header("Location: /vistas/ver_solicitudes_enviadas.php?deleted_success");
    } else {
      header("Location: /vistas/ver_solicitudes_enviadas.php?deleted_error");
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

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


    $query0 = "SELECT * FROM solicitud WHERE id_solicitud='$request'";
    $result0 = mysqli_query($conn, $query0);
    $id_pasajero = mysqli_fetch_assoc($result0);
    $id_p=$id_pasajero['id_pasajero'];
    $query0 = "SELECT * FROM usuario WHERE id_usuario='$id_p'";
    $result0 = mysqli_query($conn, $query0);
    $mail_pasajero=mysqli_fetch_assoc($result0);
    $mail_p=$mail_pasajero['mail'];
    $query0 = "SELECT * FROM solicitud WHERE id_solicitud='$request'";
    $result0 = mysqli_query($conn, $query0);
    $id_viaje = mysqli_fetch_assoc($result0);
    $id_v=$id_viaje['id_viaje'];
    $query = "SELECT * FROM viajes WHERE id_viaje='$id_v'";
    $result = mysqli_query($conn, $query);
    $trip = mysqli_fetch_assoc($result);
    
    $query = "DELETE FROM solicitud WHERE id_solicitud='$request'";
    $result = mysqli_query($conn, $query);
    
    if($result){
      header("Location: /vistas/ver_solicitudes.php?rejected_success");

      $sent = mail("$mail_p", "¡Solicitud Rechazada! Aventon", "Hola! Nos comunicamos para informarte que tu solicitud para el viaje: \n ".$trip['origen']." con destino a ".$trip['destino']." con fecha de salida ".$trip['fecha_hora']." \n fue rechazada. \n Equipo de Aventon ");
        if(!$sent){
          header("Location: /vistas/ver_solicitudes.php?notification_error_cancel");
        }

    } else {
      header("Location: /vistas/ver_solicitudes.php?deleted_error");
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

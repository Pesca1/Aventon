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

    $user_id = $_SESSION['user_id'];
    $request=$_POST['request_id'];

    $query = "SELECT * FROM usuario WHERE id_usuario='$user_id'";
    $result = mysqli_query($conn, $query);
    $user=mysqli_fetch_assoc($result);

    $query = "SELECT * FROM solicitud WHERE id_solicitud='$request'";
    $result = mysqli_query($conn, $query);
    $solicitud = mysqli_fetch_assoc($result);

    $id_v=$solicitud['id_viaje'];
    $query = "SELECT * FROM viajes WHERE id_viaje='$id_v'";
    $result = mysqli_query($conn, $query);
    $trip = mysqli_fetch_assoc($result);

    $chofer=$trip['id_usuario'];
    $query = "SELECT * FROM usuario WHERE id_usuario='$chofer'";
    $result = mysqli_query($conn, $query);
    $chofer=mysqli_fetch_assoc($result);
    $chofer_mail=$chofer['mail'];

    $query = "DELETE FROM solicitud WHERE id_solicitud='$request'";
    $result = mysqli_query($conn, $query);
    if($result){

      header("Location: /vistas/ver_solicitudes_enviadas.php?deleted_success");
      
      $sent = mail("$chofer_mail", "¡Solicitud cancelada! Aventón", "Hola! Nos comunicamos para informarte la solicitud de ".$user['nombre'].$user['apellido']." para el viaje: \n ".$trip['origen']." con destino a ".$trip['destino']." con fecha de salida ".formatDate($trip['fecha_hora'])." \n fue cancelada. \n Equipo de Aventón ");
       if(!$sent){
          header("Location: /vistas/ver_solicitudes_enviadas.php?notification_error_cancel");
        }

      if ($user['promedio_puntuacion_pasajero'] > 0){
        $average = $user['promedio_puntuacion_pasajero'] - 1;
        $query = "UPDATE usuario SET promedio_puntuacion_pasajero='$average' WHERE id_usuario='$user_id'";
        $result = mysqli_query($conn, $query);
      }
    
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

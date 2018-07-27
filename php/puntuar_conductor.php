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
      $comment = $_POST['comentario'];
      $calification_id = $_POST['calification'];
      $calification = $_POST['valor'];
      $driver_id = $_POST['driver'];

      if ($comment == ''){
 
          header("Location: /vistas/ver_calificaciones_pendientes.php?blank_comment");

          }
      else {  

    $query = "SELECT * FROM puntua_conductor WHERE id_puntua_conductor='".$calification_id."'";
    $result = mysqli_query($conn, $query);
    $thecalification = mysqli_fetch_assoc($result);

    $trip = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM viajes WHERE id_viaje='".$thecalification["id_viaje"]."'"));    


    $query = "UPDATE puntua_conductor SET estado ='".DONE."' WHERE id_puntua_conductor='$calification_id'";
    mysqli_query($conn, $query);

    $query = "UPDATE puntua_conductor SET comentario ='$comment' WHERE id_puntua_conductor='$calification_id'";
    mysqli_query($conn, $query);

    $query = "SELECT * FROM usuario WHERE id_usuario='$driver_id'";
    $result = mysqli_query($conn, $query);
    $user=mysqli_fetch_assoc($result);

    if ($calification == 'Positivo') {   

    $query = "UPDATE puntua_conductor SET calificacion ='1' WHERE id_puntua_conductor='$calification_id'";
    mysqli_query($conn, $query);

    $average = $user['promedio_puntuacion_conductor'] + 1;
    $query = "UPDATE usuario SET promedio_puntuacion_conductor='$average' WHERE id_usuario='$driver_id'";
    $result = mysqli_query($conn, $query);

    
      $driver_email = $user["mail"];
      $mail = "Hola! \n Te avisamos que ".$_SESSION['user_name']." ".$_SESSION['user_surname']." te calificó por tu viaje de ".$trip['origen']." a ".$trip['destino'].", realizado el ".formatDate($trip['fecha_hora'])." hs.\n Saludos!\n Equipo de Aventon ";
      mail($driver_email, "Recibiste una calificación como conductor", $mail);

    }

    else {

      if ($calification == 'Negativo') { 


        $query = "UPDATE puntua_conductor SET calificacion ='-1' WHERE id_puntua_conductor='$calification_id'";
        mysqli_query($conn, $query);

        if ($user['promedio_puntuacion_conductor'] > 0){
        $average = $user['promedio_puntuacion_conductor'] - 1;
        $query = "UPDATE usuario SET promedio_puntuacion_conductor='$average' WHERE id_usuario='$driver_id'";
        $result = mysqli_query($conn, $query);

        }
          $driver_email = $user["mail"];
          $mail = "Hola! \n Te avisamos que ".$_SESSION['user_name']." ".$_SESSION['user_surname']." te calificó por tu viaje de ".$trip['origen']." a ".$trip['destino'].", realizado el ".formatDate($trip['fecha_hora'])." hs.\n Saludos!\n Equipo de Aventon ";
          mail($driver_email, "Recibiste una calificación como conductor", $mail);

      }
          
      else {

          $query = "UPDATE puntua_conductor SET calificacion ='0' WHERE id_puntua_conductor='$calification_id'";
        mysqli_query($conn, $query);


          $driver_email = $user["mail"];
          $mail = "Hola! \n Te avisamos que ".$_SESSION['user_name']." ".$_SESSION['user_surname']." te calificó por tu viaje de ".$trip['origen']." a ".$trip['destino'].", realizado el ".formatDate($trip['fecha_hora'])." hs.\n Saludos!\n Equipo de Aventon ";
          mail($driver_email, "Recibiste una calificación como conductor", $mail);
      

      }
 }
  header("Location: /vistas/ver_perfil.php?calification_success");
}
      ?>


    </div>
    
<?php
  include("../vistas/footer.php");
?>

</body>

<?php 
  include("bootstrap.php"); 
  include("../php/cerrar_conexion.php");
?>

<script src="/js/registrar_usuario.js"></script>


</html>
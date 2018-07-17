<?php

session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
}else{
  header("Location: /index.php?no_session");
  exit;
}
$now = time();
if ($now > $_SESSION['expire']){
  session_destroy();
  header("Location: /index.php?session_expire");
  exit();
}else {
  $_SESSION['expire'] = time() + 60 * 60;
}
?>
<script>
  var notifications = [];
<?php
include("abrir_conexion.php");
$query = "SELECT * FROM notificacion WHERE id_usuario=".$_SESSION["user_id"];
$notifications = mysqli_query($conn, $query);
while($not = mysqli_fetch_assoc($notifications)){
  $transactionId = $not["id_transaccion"];
  $query = "SELECT * FROM transaccion WHERE id_transaccion=$transactionId";
  $transaction = mysqli_fetch_assoc(mysqli_query($conn, $query));
  $query = "SELECT * FROM viajes WHERE id_viaje=".$transaction["id_viaje"];
  $trip = mysqli_fetch_assoc(mysqli_query($conn, $query));
  if($transaction["tipo"] == 1){
    $text = "Se te debitó el viaje de ".$trip["origen"]." a ".$trip["destino"].".<br>Podes ver mas información en tu <a href=\'/vistas/ver_resumen_cuenta.php\'>resumen de cuenta</a>";
    echo "notifications.push('$text');";
  }

  $query = "DELETE FROM notificacion WHERE id_notificacion=".$not["id_notificacion"];
  mysqli_query($conn, $query);

}
include("cerrar_conexion.php");
 ?>
 </script>

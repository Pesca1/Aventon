<?php

include("verficar_sesion.php");
include("abrir_conexion.php");
include("utils.php");

$id = $_SESSION["user_id"];
$card_number = trim($_POST["card_number"]);
$card_code = trim($_POST["card_code"]);
$expiration = $_POST["exp_year"]."-".$_POST["exp_month"]."-".$_POST["exp_day"];

if(($oc = dbOcurrences($conn, "SELECT * FROM tarjetas WHERE numero='$card_number'")) == 0 ){
  $query = "INSERT INTO tarjetas (id_usuario, numero, codigo_seguridad, vencimiento) VALUES($id, $card_number, $card_code, DATE('$expiration'))";
  $result = mysqli_query($conn, $query);
  if($result){
    header("Location: /vistas/ver_tarjetas.php?reg_success");
  } else {
    header("Location: /vistas/ver_tarjetas.php?db_error");
  }
} else {
  header("Location: /vistas/ver_tarjetas.php?reg_error");
}

include("cerrar_conexion.php");

?>

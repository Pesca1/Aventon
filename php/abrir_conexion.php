<?php
$my_sql_user = "root";
$my_sql_password = "";
$my_sql_server = "localhost";
$my_sql_db= "aventon";
$table_user = "usuario";

$conn = mysqli_connect($my_sql_server, $my_sql_user, $my_sql_password, $my_sql_db);
if(!$conn){
  echo "No fue posible conectarse: ".mysql_error();
}

?>

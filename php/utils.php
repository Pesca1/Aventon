<?php
  function show_error($string){
    echo "<script>show_error('$string');</script>";
  }

  function show_success($string){
    echo "<script>show_success('$string');</script>";
  }

  function get_success($get, $string){
    if(isset($_GET[$get])){
      show_success($string);
    }
  }

  function get_error($get, $string){
    if(isset($_GET[$get])){
      show_error($string);
    }
  }

  function dbOcurrences($conn, $query){
    $result = mysqli_query($conn, $query);
    if($result){
      return mysqli_num_rows($result);
    } else {
      echo "<br>Hubo un error al conectarse con la base de datos";
      return -1;
    }
  }
?>

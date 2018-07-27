<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Aventón</title>
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <link href="/css/index.css" rel="stylesheet" type="text/css">
    <link href="/css/listar_vehiculos.css" rel="stylesheet" type="text/css">
    <link href="/css/listar_solicitudes.css" rel="stylesheet" type="text/css">
</head>
  <body>
    <?php include("header.php"); ?>
    <div id="body">
  		
    	
	<?php

    	 $calification_id=$_POST['calification_id'];

    	 $query = "SELECT * FROM puntua_conductor WHERE id_puntua_conductor='".$calification_id."'";
         $result = mysqli_query($conn, $query);
         $calification = mysqli_fetch_assoc($result);

    	 $trip = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM viajes WHERE id_viaje='".$calification["id_viaje"]."'"));

         $driver= mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='".$calification["id_conductor"]."'"));
    ?>


     <h3>Calificar al conductor <?php echo $driver["nombre"]." ".$driver["apellido"]  ?> </h3>
   	 <br>
   	 <h3>Fecha y hora del viaje: <?php echo $trip["fecha_hora"]  ?> </h3>
   	 <br>
   	 <h3> <?php echo "Desde ".$trip["origen"]." hasta ".$trip["destino"] ?> </h3>
   	 <br>
   	 <br>
     
    <div class="container">
        
            <form method="POST" action="/php/puntuar_conductor.php" enctype="multipart/form-data" autocomplete="off">
               <div class="form-group col-md-8">
                  <div class="row">
                    
                      <label for="inputComment">Comentario:</label>
                      <input type="text" name="comentario" class="form-control" id="comentario" value="">
                    
                  </div>
                </div>
              <br>
              <div class="row">
                
                <div class="col-md-5">
                        
                        <input type="radio"name="valor" value="Positivo"> Calificación positiva <br> <br>
       
                        <input type="radio"name="valor" value="Neutro" checked>  Calificación neutra <br> <br> 

                        <input type="radio"name="valor" value="Negativo">  Calificación negativa <br> <br> <br> <br>
                  
                  <input type="hidden" name="driver" value= "<?php echo $driver["id_usuario"] ?>"> 
                  <input type="hidden" name="calification" value= "<?php echo $calification_id ?>">
                  <button type="submit" class="action btn btn-danger delete_card">Calificar</button>
                </div>
              </div>
            </form>

      </div>
      </div>
      

 <?php
      include("footer.php");
    ?>
  </body>
  <?php 
    include("bootstrap.php"); 
    include("../php/cerrar_conexion.php");
  ?>
  <script src="/js/registrar_usuario.js"></script>
  <script src="/js/ver_solicitudes.js"></script>


</html>
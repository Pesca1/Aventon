<?php
  include("../php/verficar_sesion.php");
  include("../php/abrir_conexion.php");
  include("../php/utils.php");
  $user=$_SESSION["user_id"];

  $query = "SELECT * FROM puntua_conductor WHERE id_conductor='".$_SESSION["user_id"]."' AND estado=1";
  if (dbOcurrences($conn, $query)==0){  
	  $query = "SELECT * FROM puntua_pasajero WHERE id_pasajero='".$_SESSION["user_id"]."' AND estado=1";
  	  if (dbOcurrences($conn, $query)==0){  
  	  		header("Location: /vistas/ver_perfil.php?no_califications");
  	  }	
  }
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
    	 <h1>Calificaciones recibidas</h1>

<?php     
        $query = "SELECT * FROM puntua_conductor WHERE id_conductor='".$_SESSION["user_id"]."'";
        $result = mysqli_query($conn, $query);
              if(!$result){
                echo "<h2>Ocurrió un error al conectarse a la base de datos, por favor, intentelo mas tarde.</h2>";
              } else {
               while($calification = mysqli_fetch_assoc($result)){
               		
               		$trip = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM viajes WHERE id_viaje='".$calification["id_viaje"]."'"));

               		$passenger= mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='".$calification["id_pasajero"]."'"));

        ?>
       			 <?php
            		if($calification["estado"] == DONE) {
          		 ?>
          		    <div class="vehicle">
                  	<div class="vehicle-info">
                  	    <?php
            			if($calification["calificacion"] == 1) {
          		 		?>
          		 			<h5>Calificación positiva</h5>
          		 		<?php
          		 		}else {
          		 			if($calification["calificacion"] == 0){ 
          		 		?>
          		 				<h5>Calificación neutra</h5>
          		 		<?php
          		 				}else {
          		 		?>
          		 					<h5>Calificación negativa</h5>
          		 		<?php
          		 				}
          		 			}
          		 		
          		 		?>
          		 	
              	  	<h5>Pasajero: <?= $passenger["nombre"]." ".$passenger["apellido"] ?></h5>
          			
          			<?= $trip["origen"]." --> ".$trip["destino"] ?>
          			<br>
          			Fecha: <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?>
                    <br>
                    Comentario: <?php echo $calification["comentario"]; ?>
                    </div>
                    </div>  
				<?php
          			}
          		}
          	}
          		?>


		<?php     
        $query = "SELECT * FROM puntua_pasajero WHERE id_pasajero='".$_SESSION["user_id"]."'";
        $result = mysqli_query($conn, $query);
              if(!$result){
                echo "<h2>Ocurrió un error al conectarse a la base de datos, por favor, intentelo mas tarde.</h2>";
              } else {
               while($calification = mysqli_fetch_assoc($result)){
               		
               		$trip = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM viajes WHERE id_viaje='".$calification["id_viaje"]."'"));

               		$driver= mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM usuario WHERE id_usuario='".$calification["id_conductor"]."'"));
        
       			 
            		if($calification["estado"] == DONE ){
          		 ?>
          			<div class="vehicle">
                	<div class="vehicle-info">
                	    <?php
            			if($calification["calificacion"] == 1) {
          		 		?>
          		 			<h5>Calificación positiva</h5>
          		 		<?php
          		 		}else {
          		 			if($calification["calificacion"] == 0){ 
          		 		?>
          		 				<h5>Calificación neutra</h5>
          		 				<?php
          		 				}else {
          		 				?>
          		 					<h5>Calificación negativa</h5>
          		 	<?php
          		 				}

          		 			}
          		 		
          		 	?>
                  	
                  	<h5>Conductor: <?= $driver["nombre"]." ".$driver["apellido"] ?></h5>
          			
          			<?= $trip["origen"]." --> ".$trip["destino"] ?>
          			<br>
          			Fecha: <?= date("d/m/Y H:i", strtotime($trip["fecha_hora"])); ?>
                    <br>
                    Comentario: <?php echo $calification["comentario"]; ?>
                    </div>
                  	</div>

				    <?php
          			}
          		}
          	}
          		?>

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

  <?php 
  get_error("blank_comment", "Debe escribir un comentario!");
  ?>

</html>
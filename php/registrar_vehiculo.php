<!DOCTYPE html>
<html>
  <head>
    <title>Registrar vehículo</title>
    <meta charset= "UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/index.css" rel="stylesheet" type="text/css">
 </head>

<body>

<?php
   include("verficar_sesion.php");
   include("../vistas/header.php"); 
?>



 <div class="form_container">
    <h2>Registrar vehículo</h2>
    <br>

    <form method="POST" action="/php/alta_vehiculo.php" id="registrovehiculo">
              
        <div class="form-group col-md-6">
            <h3>Ingrese la marca:</h3>
            <input type="text" class="form-control" name="brand" required="required">
        </div>
               
        <div class="form-group col-md-6">
            <h3>Ingrese el modelo:</h3>
            <input type="text" class="form-control" name="model" required="required">
        </div>

        <div class="form-group col-md-6">
            <!-- pattern="construir expresión regular para aceptar solamente formatos de patente válidos en Argentina"
            "[A-Za-z]{3}[0-9]{3}" para formato común, pero es complicado porque tambien hay formato de moto, el nuevo, los viejos, etc. y habría que normalizar ingreso de mayusculas y minúsculas-->
            <h3>Ingrese la patente:</h3>
            <input type="text" class="form-control" name="patent" required="required">
        </div>

        <div class="form-group col-md-6">
            <h3>Ingrese la cantidad de asientos disponibles:</h3>
            <input type="number" class="form-control" name="seating" min="1" max="45" value= "1" required="required">
        </div>
        <br>
        <br>

    </form>
</div>


<div class="form_container">
    	<br>  
    	<h3>Seleccione una foto del vehículo</h3>
    	<br>
        <br>
    	<!-- <input type="hidden" name="MAX_FILE_SIZE" value="5000000" required="required" formenctype="multipart/form-data" id="registrovehiculo">-->
        <input type="file" name="car_picture" formenctype="multipart/form-data" id="registrovehiculo">
        <br>
        <br>
        <br>
        <br>
        <div class="form-group col-md-6">
            <button type="submit" class="btn btn-primary" formenctype="multipart/form-data" id="registrovehiculo">Registrar vehículo</button>
        </div>
</div>




</div>


<?php include("../vistas/footer.php") ?>
	
</body>

<?php

if(isset($_GET['car_error'])){
      echo '<script> show_error("No se pudo dar de alta el vehículo"); </script>';
    }


include("../vistas/bootstrap.php"); ?>
</html>

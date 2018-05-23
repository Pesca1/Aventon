<?php include("verficar_sesion.php"); ?>
<!DOCTYPE html>
<html>
  <head>
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <link href="/css/index.css" rel="stylesheet" type="text/css">
    <link href="/css/listar_vehiculos.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php include("header.php"); ?>
    <div id="body">
    	<h1>Mis Vehículos</h1>
		<?php 
			include("abrir_conexion.php");

			$id = $_SESSION['user_id'];
			$query = "SELECT * FROM vehiculo WHERE id_usuario='$id'";
			$result = mysqli_query($conn, $query);
			if($result){
				$vehicle = mysqli_fetch_assoc($result);
				if($vehicle){
					while($vehicle) {
						$plate = $vehicle['patente'];
						$query = "SELECT foto FROM fotos_vehiculo WHERE patente='$plate'";
						$photo_query = mysqli_query($conn, $query);
						?>

		<div class="vehicle">
			<div class="vehicle-info">
				<h3><?php echo $vehicle['marca']." ".$vehicle['modelo']; ?></h3>
				<?php echo $vehicle['asientos']." asientos - Patente: ".$vehicle['patente']; ?>
				<br>
				<br>
				<button class="btn"><a href="modificar_vehiculo.php">Modificar Información</a></button>
			</div>
			<div class="vehicle-photos">
				<?php
					while($photo = mysqli_fetch_assoc($photo_query)){
						$photo_src = $photo['foto'];
						echo "<img src='/img/vehicles/".$photo_src."'/>";
					}
				?>
			</div>
		</div>

						<?php
						$vehicle = mysqli_fetch_assoc($result);
					}
				} else {
					?>

		<h2>No hay ningún vehículo registrado!</h2>

					<?php
				}
			} else {
				echo "Hubo un error al conectarse a la base de datos, por favor intente nuevamente mas tarde.";
			}

			include("cerrar_conexion.php");
		?>
    </div>
    <?php include("footer.php") ?>
  </body>
  <?php include("bootstrap.php"); ?>
</html>

<?php include("../php/verficar_sesion.php"); include("../php/utils.php"); ?>
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
			include("../php/abrir_conexion.php");

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
				<?php
					echo $vehicle['asientos']." asientos - Patente: ".$plate;
				?>
				<br>
				<br>
				<form class="" action="/vistas/editar_vehiculo.php" method="post">
          <input type="hidden" name="plate" value="<?php echo $vehicle['patente'];?>">
          <button class="btn" name="">Modificar Información</button>
        </form>
				<form class="" action="/php/baja_vehiculo.php" method="post">
          <input type="hidden" name="plate" value="<?php echo $vehicle['patente'];?>">
          <button class="btn btn-danger delete_vehicle" name="">Eliminar</button>
        </form>
			</div>
			<div class="vehicle-photos">
				<?php
					while($photo = mysqli_fetch_assoc($photo_query)){
						$photo_src = "/img/vehicles/".$photo['foto'];
						echo "<a href='$photo_src'><img src='$photo_src'/></a>";
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

			include("../php/cerrar_conexion.php");
		?>
    <br>
    <button class="btn btn-success"><a href="/php/registrar_vehiculo.php">Agregar vehículo</a></button>
    </div>
    <?php include("footer.php") ?>
  </body>
  <?php include("bootstrap.php"); ?>
  <script src="/js/registrar_usuario.js" ></script>
  <script src="/js/listar_vehiculos.js"></script>
  <?php
  	if(isset($_GET['success'])){
  		echo "<script> show_success('Vehículo registrado con éxito!'); </script>";
  	}
    if(isset($_GET['success_change'])){
      echo '<script> show_success("¡Acción exitosa!"); </script>';
    }
  	if(isset($_GET['pending'])){
  		echo "<script> show_error('No se puede eliminar el vehículo, hay viajes pendientes con el.'); </script>";
  	}
  	if(isset($_GET['deleted'])){
  		echo "<script> show_success('Vehículo eliminado!'); </script>";
  	}
  	if(isset($_GET['error'])){
  		echo "<script> show_error('Hubo un error al intentar eliminar su vehículo. Por favor vuelva a intentarlo mas tarde.'); </script>";
  	}
        get_error("edit_pending", "No es posible modificar el vehículo, ya que tiene viajes pendientes.");
  ?>
</html>

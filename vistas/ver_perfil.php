<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Ver perfil</title>
    <link href="../bootstrap-4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/index.css" rel="stylesheet" type="text/css">
    <link href="../css/verPerfil.css" rel="stylesheet">
    <link href="/fonts/fontawesome/fontawesome-all.css" rel="stylesheet">
  </head>

  <body>

<?php  ?>

<?php
      include("../php/verficar_sesion.php");
      include("../php/abrir_conexion.php");
      include("header.php");
      include("../php/utils.php");
      $table_user = "usuario";
      $query = mysqli_query($conn,"SELECT * from $table_user WHERE mail = '$_SESSION[user_mail]'");
      $mostrar=mysqli_fetch_assoc($query);
      $user_info = $mostrar['contrasenia'];
      $user_picture = ($mostrar['foto_perfil']!='')? '/img/profile_users/'.$mostrar['foto_perfil'] : '/img/system/default_user.jpg';
?>
<div class="container">
  <div class="row">
    <div class="col-md-8">
      <main role="main">
          <br>
          <br>
        <table>
    	<tr>
    	<td width="37%">
    	</td>
    	<td>
          <div class="container marketing">
            <!-- Foto circular del usuario y debajo su información -->

    	<div class="row">
              <div class="col-lg-4">
                <img class="rounded-circle" src=<?php echo "'$user_picture'";?>  alt="Foto de perfil" width="140" height="140">
                <h2> <?php echo $mostrar["nombre"]; echo ' '; echo $mostrar["apellido"]; ?></h2>
    		 <h2>
    	       <?php echo $_SESSION["user_mail"]; ?>
    		</h2>
                <p> Puntuación de conductor: <?php echo $mostrar["promedio_puntuacion_conductor"];?><br>
                   Puntuación de pasajero: <?php echo $mostrar["promedio_puntuacion_pasajero"];?><br>
                   Ahorro: <?php echo $mostrar["ahorro"];?> <br>
                   Gasto: <?php echo $mostrar["gasto"]; ?> <br>
                </p>
                <p></p>

              </div><!-- /.col-lg-4 -->
            </div><!-- /.row -->

         </div> <!-- /.container   -->
    	</td>
    	</tr>
    	</table>
     </main>
    </div>
    <div class="col-md-4">
      <br><br><br><br>
      <button class="btn btn-warning" ><a href="/vistas/editar_perfil.php">Editar perfil</a></button>
      <button class="btn btn-danger" ><a href="/vistas/editar_contrasenia.php">Editar contraseña</a></button>
      <button class="btn" ><a href="/vistas/ver_tarjetas.php">Mis Tarjetas</a></button>
  </div>
</div>





    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write("<script src='../../assets/js/vendor/jquery-slim.min.js'></script>")</script>
    <script src="../bootstrap-4.1.1/assets/js/vendor/popper.min.js"></script>
    <script src="../bootstrap-4.1.1/dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Dont actually copy the next line! -->
    <script src="../bootstrap-4.1.1/assets/js/vendor/holder.min.js"></script>
    <?php 
      include("footer.php");
      include("bootstrap.php");
    ?>
  </body>
   <script src="/js/registrar_usuario.js"></script>
   <?php
     if(isset($_GET['success_change'])){
       echo '<script> show_success("¡Acción exitosa!"); </script>';
     }
     get_error("no_trips", "<span style=\"color: black;\">No hay ningún viaje registrado!</span>");
   ?>
</html>

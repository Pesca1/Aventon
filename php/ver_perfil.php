<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Ver perfil</title>

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="/css/index.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="../css/verPerfil.css" rel="stylesheet">
  </head>
  
  <body>
    
    <!--      Anterior header hasta la implementacion del header uniforme para todas las pantallas
    <header>
      <nav class="navbar navbar-expand-md navbar-light fixed-top" style="background-color: #f44242;">
        <a class="navbar-brand" href="#">Aventón</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Ver solicitudes pendientes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Cerrar sesión</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>  -->

<header>  
<div id="header">
  <img id="logo" src="/img/logo.jpeg" />
  <form id="search" class="form-inline my-2 my-lg-0">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    <button class="btn  my-2 my-sm-0" type="submit">Search</button>
  </form>
  <button class="btn"><a href="/php/cerrar_sesion.php">Cerrar Sesión</a></button>
  <button class="btn"><a href="/php/listar_vehiculos.php">Mis Vehículos</a></button>
  <button class="btn"><a href="/php/listar_viajes.php">Mis Viajes</a></button>
  <button class="btn"><a href="/php/ver_perfil.php">Mi Perfil</a></button>
</div>
</header>

<?php
      include("verficar_sesion.php");
      include("abrir_conexion.php");
      $table_user = "usuario";
      $query = mysqli_query($conn,"SELECT * from $table_user WHERE mail = '$_SESSION[user_mail]'");
      $mostrar=mysqli_fetch_assoc($query);
      $user_info = $mostrar['contrasenia'];  
      $user_picture = ($mostrar['foto_perfil']!='')? $mostrar['foto_perfil'] : '/img/system/default_user.jpg';
?> 
  

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
            <p><a class="btn btn-secondary" href="#" role="button">Mis viajes &raquo;</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->
	

     </div> <!-- /.container   -->
	</td>	
	</tr>
	</table>
 </main> 
   
   

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
    <?php include("footer.php") ?>
  </body>
   ?>  
</html>



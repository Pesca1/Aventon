<div id="header">
  <img id="logo" src="/img/logo.jpeg" />
  <form id="search" class="form-inline my-2 my-lg-0" action="/vistas/buscar_viajes.php">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
    <a class="btn btn-light" href="/vistas/listar_todos_los_viajes.php" >buscar</a>
  </form>
  <button class="btn"><a href="/php/cerrar_sesion.php">Cerrar Sesión</a></button>
  <button class="btn"><a href="/vistas/listar_vehiculos.php">Mis Vehículos</a></button>
  <button class="btn"><a href="/vistas/ver_viajes.php">Mis Viajes</a></button>
  <button class="btn"><a href="/vistas/ver_solicitudes.php">Solicitudes</a></button>
  <button class="btn btn-dark" ><a style="color: white" href="/vistas/ver_perfil.php"><?php echo  $_SESSION["user_name"] ?></a></button>
  <button class="btn" id="hello-user-css">Bienvenido!</button>
  <button class="btn" id="left-button"><a href="/vistas/listar_todos_los_viajes.php">Viajes</a></button>
</div>

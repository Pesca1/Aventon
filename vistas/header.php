<div id="header">
  <img id="logo" src="/img/logo.jpeg" />
  <form id="search-form" class="form-inline" method="post" action="/vistas/buscar_viaje.php">
    <input <?= (isset($_POST["origin"]))?"value='".$_POST["origin"]."'":"" ?> type="text" name="origin" class="form-control mb-2 mr-sm-2 search s1" id="inlineFormInputName2" placeholder="Origen">

    <label class="sr-only" for="inlineFormInputGroupUsername2">Username</label>
    <div class="input-group mb-2 mr-sm-2">
      <input <?= (isset($_POST["destination"]))?"value='".$_POST["destination"]."'":"" ?> type="text" name="destination" class="form-control search s2" id="inlineFormInputGroupUsername2" placeholder="Destino">
    </div>

    <div class="form-check mb-2 mr-sm-2">
      <input <?= (isset($_POST["date"]))?"value='".$_POST["date"]."'":"" ?> type="date" name="date" class="form-control search" id="date" name="date" placeholder="Fecha">
    </div>

    <button type="submit" class="btn mb-2" id="search-button">Buscar</button>
  </form>
  <button class="btn"><a href="/php/cerrar_sesion.php">Cerrar Sesión</a></button>
  <button class="btn"><a href="/vistas/listar_vehiculos.php">Mis Vehículos</a></button>
  <button class="btn"><a href="/vistas/ver_viajes.php">Mis Viajes</a></button>
  <button class="btn"><a href="/vistas/ver_solicitudes.php">Solicitudes</a></button>
  <button class="btn btn-dark" ><a style="color: white" href="/vistas/ver_perfil.php"><?php echo  $_SESSION["user_name"] ?></a></button>
  <button class="btn" id="hello-user-css">Bienvenido!</button>
  <button class="btn" id="left-button"><a href="/vistas/listar_todos_los_viajes.php">Viajes</a></button>
</div>

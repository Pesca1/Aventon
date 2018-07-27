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
  <button class="btn" id="left-button"><a href="/vistas/listar_todos_los_viajes.php">Todos los viajes</a></button>
  <a href="/php/controlar_pagos.php">Controlar pagos</a>
  <div class="btn-group float-right">
    <button type="button" class="btn btn-dark"><a href="/vistas/ver_perfil.php" style="color: white;"><?= $_SESSION["user_name"] ?></a></button>
    <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="/vistas/ver_viajes.php">Mis viajes</a>
      <a class="dropdown-item" href="/vistas/listar_vehiculos.php">Mis vehículos</a>
      <a class="dropdown-item" href="/vistas/ver_solicitudes.php">Solicitudes recibidas</a>
      <a class="dropdown-item" href="/vistas/ver_solicitudes_enviadas.php">Solicitudes enviadas</a></button>
      <a class="dropdown-item" href="/vistas/ver_calificaciones_pendientes.php">Calificaciones pendientes</a></button>
      <a class="dropdown-item" href="/vistas/ver_resumen_cuenta.php">Resumen de cuenta</a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="/php/cerrar_sesion.php">Cerrar sesión</a>
    </div>
  </div>


</div>

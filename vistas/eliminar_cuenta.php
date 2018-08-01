<!DOCTYPE html>
<html>
  <head>
    <title>Aventón</title>
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" >
    <link href="/css/index.css" rel="stylesheet" type="text/css">
    <link href="/css/listar_vehiculos.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <?php
      include("../php/verficar_sesion.php");
      include("../php/abrir_conexion.php");
      include("../php/utils.php");
      include("../vistas/header.php");
    ?>
    <div id="body">
      <h1>Eliminar cuenta</h1>
    <h2>Está seguro de que desea eliminar su cuenta?</h2>
      <br>
      <h3>Esta acción no se puede revertir, una vez eliminada todos sus datos de Aventón dejarán de existir.</h3>
      <br>
      <a href="/vistas/ver_perfil.php" class="btn btn-success">Cancelar, conservar mi cuenta</a>
      <a href="/php/eliminar_cuenta.php?id=<?= $_SESSION["user_id"] ?>" class="btn btn-danger">Sí, eliminar mi cuenta</a>
    </div>
    <?php
      include("../vistas/footer.php");
    ?>
  </body>
  <?php 
    include("../vistas/bootstrap.php"); 
    include("../php/cerrar_conexion.php");
  ?>
  <script src="/js/registrar_usuario.js"></script>
</html>

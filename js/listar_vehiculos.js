$("#delete_vehicle").click(function(e){
  e.preventDefault();
  if(window.confirm("¿Esta seguro de que desea eliminar el vehículo?")){
    $.redirectPost("/php/eliminar_vehiculo.php", {patente: ""});
  }
});

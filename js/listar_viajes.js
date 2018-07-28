$(".delete_trip").click(function(e){
  return window.confirm("¿Esta seguro de que desea eliminar el viaje? No posee solicitudes");
});
$(".delete_trip_with_request").click(function(e){
  return window.confirm("¿Esta seguro de que desea eliminar el viaje? Posee solicitudes por lo que se le restaran puntos como chofer");
});
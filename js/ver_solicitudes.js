$("#delete-request").submit(function (e){
  return confirm("¿Está seguro de que desea eliminar la solicitud?");
});
$("#delete-request-accept").submit(function (e){
  return confirm("¿Está seguro de que desea eliminar la solicitud? Al estar aceptada se le restara un punto como pasajero");
});

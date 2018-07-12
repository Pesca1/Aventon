function dayChecked(){
  var checked = false;
  $(".day").each(function(e){
    if($(this).prop("checked")){
      checked = true;
    }
  });
  return checked;
}

$("#trip_reg").submit(function(e){
  if(parseInt($("#price").val()) <= 0){
    show_error("El monto debe ser mayor a $0");
    return false;
  } else if(!dayChecked()){
    show_error("Seleccione uno o más días para su viaje");
    return false;
  }
});

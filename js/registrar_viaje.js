$("#trip_reg").submit(function(e){
  var day = $("#day").val();
  var month = $("#month").val();
  var current_day = new Date().getDate();
  var current_month = new Date().getMonth()+1;
  if((current_month+1 == month) && (day > current_day)){
    show_error("La fecha del viaje debe ser dentro del proximo mes.");
    return false;
  } else if((month == current_month) && (day <= current_day)){
    show_error("La fecha ingresada es inválida.");
    return false;
  } else if(parseInt($("#price").val()) <= 0){
    show_error("El monto debe ser mayor a $0");
    return false;
  }
});

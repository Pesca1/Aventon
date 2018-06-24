function isInteger(string){
  for(var i = 0; i < string.length; i++){
    if(!Number.isInteger(parseInt(string[i]))){
      return false;
    }
  }
  return true;
}

function isExpired(exp_day, exp_month, exp_year){
  var today = new Date();
  var day = today.getDate();
  var month = today.getMonth()+1; //Enero es 0
  if((exp_year == 2018) && ((exp_month < month) || ((exp_month == month) && (exp_day <= day))) ){
    return true;
  }
  return false;
}

$("#card_registration").submit(function (e){
  var card_number = $.trim($("#card_number").val());
  var card_code = $.trim($("#card_code").val());
  var year = $("#year").val();
  var month = $("#month").val();
  var day = (new Date(year, month, 0)).getDate();
  console.log(day+"/"+month+"/"+year);
  if((card_number.length != 16) || !isInteger(card_number) ){
    show_error("Número de tarjeta inválido.");
    return false;
  } else if((card_code.length != 3) || !isInteger(card_code)){
    show_error("Código de seguridad inválido.");
    return false;
  } else if(isExpired(day, month, year)){
    show_error("Fecha de vencimiento inválida.");
    return false;
  }
});

function show_error(text){
	$('body').append('<div class="error_container"></div><div class="error"><h3>'+ text +'</h3></div>');
	$('.error').click(function(){
		$(this).css('display', 'none');
		$('.error_container').css('display', 'none');
	});
	$('.error_container').click(function(){
		$(this).css('display', 'none');
		$('.error').css('display', 'none');
	});
}

function show_success(text){
	$('body').append('<div class="error_container"></div><div class="success"><h3>'+ text +'</h3></div>');
	$('.success').click(function(){
		$(this).css('display', 'none');
		$('.error_container').css('display', 'none');
	});
	$('.error_container').click(function(){
		$(this).css('display', 'none');
		$('.success').css('display', 'none');
	});
}

function validateEmail(sEmail) {
    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}

$('#register_form').submit(function(){

	var passwd = $.trim($('#passwd').val());
	var passwd_confirm = $.trim($('#passwd_confirm').val());
	var birthday = parseInt($('#day').val());
	var birthmonth = parseInt($('#month').val());
	var birthyear = parseInt($('#year').val());

	var today = new Date();
	var day = today.getDate();
	var month = today.getMonth()+1; //Enero es 0
	var year = today.getFullYear();

	if(passwd != passwd_confirm){
		show_error('Los campos de contraseña deben coincidir.');
		return false;
	} else if( (birthyear == year-18) && ( (birthmonth > month) || (birthmonth == month && birthday > day) ) ){
		show_error('Aventón solo es apta para mayores de edad.');
		return false;
	}
});

$.extend(
{
    redirectPost: function(location, args)
    {
        var form = $('<form></form>');
        form.attr("method", "post");
        form.attr("action", location);

        $.each( args, function( key, value ) {
            var field = $('<input></input>');

            field.attr("type", "hidden");
            field.attr("name", key);
            field.attr("value", value);

            form.append(field);
        });
        $(form).appendTo('body').submit();
    }
});

$("#recover_passwd").click(function (e){
	e.preventDefault();
	var mail = $.trim($("#login_mail").val());
	if((mail.length != 0) && validateEmail(mail)){
		$.redirectPost("/php/recuperar_contraseña.php", {user_mail: mail});
		return false;
	} else {
		show_error("Ingrese una dirección de email válida.");
		return false;
	}
});

$('#search-form').submit(function(e){
  var origin = $('.s1').val();
  var dest = $('.s2').val();
  var date = $('#date').val();
  if((origin == "") && (dest == "") && (date == "")){
    show_error("Por favor, especifique origen, destino o fecha del viaje a buscar.");
    return false;
  } else if(Date.parse(date) < Date.now()){
    show_error("Especifique una fecha posterior al día de hoy.");
    return false;
  }
});

for(var i = 0; i < notifications.length; i++){
  show_success(notifications[i]);
}

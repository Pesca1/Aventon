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
	$('.error').css('background-color', 'rgb(226, 104, 104)');
}

function show_success(text, color){
	show_error(text);
	$('.error').css('background-color', 'rgb(189, 255, 113)');
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

/*$("#recover_passwd").click(function (e){
	e.preventDefault();
	var mail = $.trim($("#login_mail").val());
	if((mail.length != 0) && validateEmail(mail)){
		$.post("/php/recuperar_contraseña.php", mail, function(data){
			show_success("La contraseña fue enviada a su dirección de email. Respuesta: data");
		});
		return false;
	} else {
		show_error("Ingrese una dirección de email válida.");
		return false;
	}
});*/

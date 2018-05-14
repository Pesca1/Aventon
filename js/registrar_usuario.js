$('#register_form').submit(function(){

	var passwd = $.trim($('#passwd').val());
	var passwd_confirm = $.trim($('#passwd_confirm').val());

	if(passwd != passwd_confirm){
		$('body').append('<div class="error_container"></div><div class="error"><h3>Los campos de contraseña deben coincidir.</h3></div>');
		$('.error').click(function(){
			$(this).css('display', 'none');
			$('.error_container').css('display', 'none');
		});
		$('.error_container').click(function(){
			$(this).css('display', 'none');
			$('.error').css('display', 'none');
		});
		return false;
	} else {

	}
});
$("#add_photo").click(function(e){
	e.preventDefault();
	var picture_number = parseInt($("#number").val())+1;
	$("#number").val(picture_number);
	$("#pictures").append('<input type="file" name="car_picture_'+picture_number+'" formenctype="multipart/form-data" class="registrovehiculo">');
});
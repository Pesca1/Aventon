$("#add_photo").click(function(e){
	e.preventDefault();
	var picture_number = parseInt($("#number").val())+1;
	$("#number").val(picture_number);
	$("#pictures").append('<input type="file" name="car_picture_'+picture_number+'" formenctype="multipart/form-data" class="registrovehiculo">');
});

$("#old_pictures button").click(function(e){
  e.preventDefault();
  var delete_number = parseInt($("#delete_number").val())+1;
  var picture_name = $(this).siblings(".picture_name").val() ;
  $("#delete_number").val(delete_number);
  $("#old_pictures").append("<input type='hidden' name='delete_picture_"+delete_number+"' value='"+picture_name+"' />");
  $(this).parent().css("display", "none");
});

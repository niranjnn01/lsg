$(document).ready(function(){
	
<?php /*profile information form*/?>
profileEdit = $("#profileEdit");
profileEdit.validate({
rules: {
	first_name: {required:true},
	last_name: {required:true},
	gender: {required:true}
	
},
success: function(label) {
	// set &nbsp; as text for IE
	label.html("&nbsp;").addClass("form_label_success");
	
},
errorPlacement: function(error, element) {
	if (element.attr("name") == "gender")
		error.insertAfter("#male_label");
	else
		error.insertAfter(element);

}
});

});


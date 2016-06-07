$(document).ready(function(){
	
$("#contactpurposeCreateForm").validate({
	rules: {
		title: {required:true},
		email: {required:true, email:true},
		reciever_name: {required:true},
		email_template_id: {required:true,min:1},
		success_message: {required:true},
		status: {required:true}
	},
	messages:{
		email_template_id: {min:"This field is required."},
	},
	success: function(label) {
		// set &nbsp; as text for IE
		label.html("&nbsp;").addClass("form_label_success");		
	},
	errorPlacement: function(error, element) {
			error.insertAfter(element);
	}

});
});


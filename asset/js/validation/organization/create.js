$(document).ready(function(){
	$("#organizationCreateForm").validate({
		rules: {
			 title: {required:true},
			 excerpt: {required:true},
			 description: {required: true},
			 status: {required: true}
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") == "description"){
				error.insertAfter('.organization_desc_err_position');
			} else {
				error.insertAfter(element);
			}
		},
		messages: {
			article_type:{min:"This field is required."},
			article_status:{min:"This field is required."}
		},
		success: function(span) {
			// set &nbsp; as text for IE
			span.html("&nbsp;").addClass("form_label_success");
		}
	});
	
	$('#excerpt').limit('<?php echo $excerpt_character_length;?>','#charsLeft');
	
});
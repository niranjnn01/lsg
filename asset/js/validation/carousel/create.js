$(document).ready(function(){
	$("#carouselCreateForm").validate({
		rules: {
			 title: {required:true},
			 description: {required: true},
			 image_url: {required: true}
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") == "description"){
				error.insertAfter('.program_desc_err_position');
			} else {
				error.insertAfter(element);
			}
		},
		success: function(span) {
			// set &nbsp; as text for IE
			span.html("&nbsp;").addClass("form_label_success");
		}
	});
	
	$('#description').limit('<?php echo $excerpt_character_length;?>','#charsLeft');
	
});
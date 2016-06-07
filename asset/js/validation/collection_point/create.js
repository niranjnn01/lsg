$(document).ready(function(){
	$("#collectionPointCreateForm").validate({
		rules: {
			 title: {required:true},
			 status: {required: true}
		},
		errorPlacement: function(error, element) {
			if (element.attr("name") == "description"){
				error.insertAfter('.collection_point_desc_err_position');
			} else {
				error.insertAfter(element);
			}
		},
		messages: {
		},
		success: function(span) {
			// set &nbsp; as text for IE
			span.html("&nbsp;").addClass("form_label_success");
		}
	});
	
	
	
});
$(document).ready(function(){
	/*
	$("#newPasswordForm").validate({
		rules: {
			 password: {required:true, minlength:<?php echo $password_min_length;?>},
			 captcha: {required:true},
			 password_again: {required:true, minlength:<?php echo $password_min_length;?>, equalTo: "#password"}
		},
		messages: {
			password_again:{equalTo:"Should be same as New Password"}
		},
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("form_label_success");
			
		}
	});
	*/
	
	$(".cv_source").click(function () {
		
		
		switch( $(this).val() ) {
			case "upload_file":
				$("#create_cv_cnt").collapse('hide');
				$("#upload_file_cnt").collapse('show');
				break;
			case "create_cv":
				//$("#upload_file_cnt").collapse('hide');
				$("#upload_file_cnt").collapse('hide');
				$("#create_cv_cnt").collapse('show');
				
				break;
		}
		
	});
	
	
	
	$('#add_employer').on('click', function (event) {
		
		var iNumber = parseInt( $('.employment_details').last().find(".order_no .badge").html() );
		iNumber = iNumber + 1;
		
		$('.employment_details').last().clone()
		.appendTo('.employment_details_cnt');
		
		$('.employment_details').last().find("input[type='text']").val("");
		
		$('.employment_details').last().find(".order_no .badge").html(iNumber);
		
		event.preventDefault();
		event.stopPropagation();
		
	});
	
	$('#add_education').on('click', function (event) {
		
		var iNumber = parseInt( $('.education_details').last().find(".order_no .badge").html() );
		iNumber = iNumber + 1;
		
		$('.education_details').last().clone()
		.appendTo('.education_details_cnt');
		
		$('.education_details').last().find("input[type='text']").val("");
		
		$('.education_details').last().find(".order_no .badge").html(iNumber);
		
		event.preventDefault();
		event.stopPropagation();
		
	});
	
	$('#add_certificate').on('click', function (event) {
		
		var iNumber = parseInt( $('.certificate_details').last().find(".order_no .badge").html() );
		iNumber = iNumber + 1;
		
		$('.certificate_details').last().clone()
		.appendTo('.certificate_details_cnt');
		
		$('.certificate_details').last().find("input[type='text']").val("");
		
		$('.certificate_details').last().find(".order_no .badge").html(iNumber);
		
		event.preventDefault();
		event.stopPropagation();
		
	});
	
	
	
	$('#cv_file').bind('change', function() {
		
		//this.files[0].size gets the size of your file.
		
		var size = (this.files[0].size / 1024);
		//size = size / 1024;
		
		$('#cv_file_size').html( "Document Size : " + Math.round(size) + " Kb" );
		
		
	});
	
});
$(document).ready(function(){
	
	$('.perm_delete').click(function(){
	
		if(confirm("Sure you want to continue?")){
			
			//var p = $(this).parent().parent().parent().attr('class').split(" ");
			//var c=p[2];
			//$('.' + c).block({ message: '<?php echo $waiting_gif_text;?>' });
			
			$.post(
			"<?php echo $base_url;?>" + "contact_us/delete_purpose/" + $(this).attr('id'),
			{},
			function (data){
				if(data.error == ''){
					$('.'+data.c).unblock();
					alert('The purpose has been delete from the system');
					window.location.reload();
				} else {
					if (data.error_type == <?php echo $error_types['not_logged_in']?>){
						window.location = "<?php echo $base_url.'user/login';?>";
					} else {
						$('.'+data.c).unblock();
						//alert();
						//$(c).insertBefore($('.grid_container'));
						$(data.error).insertBefore('.grid_container');
					}
				}
			},
			"json"
			);		
		}
		
	});

});


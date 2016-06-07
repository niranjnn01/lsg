$(document).ready(function() {
$('.bkp_btn').click(function(){
	
	var type = $(this).attr('id');
	
	$( '#status_' + type ).hide();
	$( '#status_' + type ).removeClass('success');
	$( '#status_' + type ).removeClass('failure');
	$( '#status_' + type ).addClass('sf');
	$( '#status_' + type ).text('Please Wait');
	$( '#status_' + type ).toggle();
	
	$.get(
		base_url + 'maintenance/do_backup/' + type,
		'',
		function (data){
			var status_div = '#status_' + data.type;
			
			if(data.status == 1) {
				$( status_div ).addClass('success sf');
				$( status_div ).text('DONE');
			} else {
				$( status_div ).addClass('failure sf');
			}
			
			$( status_div ).text(data.message);
		},
		'json'
	);
});


	$("#backups_admin").tabs();
});
$(document).ready(function() {
	$('.del_sett').click(function(){
		if(confirm("Are you sure you want to delete this setting?")){
			gotoPage('maintenance/delete_setting/' + $(this).attr('id'));	
		}
	});
});
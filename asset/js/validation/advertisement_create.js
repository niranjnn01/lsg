$(document).ready(function(){
$("#advertisementCreateForm").validate({
	rules: {
		fruit_typeahead: {required:true},
		item_type: {required:true},
		fruit_typeahead: {required:true},
		number: {required:true},
		location: {required:true},
		contact_number: {required:true},
		district: {required:true},
		place: {required:true, min:1}
	},
	messages: {
		place: {min:"This field is required"}
	},
	submitHandler: function(form) {
		
		var form_temp 	= form;
		var proceed 	= true;
		
		/*
		if( markerLatLng == null ) {
			alert('select your location');
			proceed = false;
		}
		*/
		
		if( proceed ) {
			
			$('#adv_container').block({
										message: '<?php echo $waiting_gif_text;?>',
										css:{width:'60%'} });
			
			$.ajax({
				type:'post',
				url:'<?php echo $base_url;?>ajax/check_valid_captcha',
				data:{"captcha":form.captcha.value},
				success: function(data){
					
					$('#adv_container').unblock();
					if( data.success == 1 ){
						
						//clear the form field
						
						console.log('success');
						form.submit();
					} else {
						
						console.log('failure');
						return false;
					}				
				},
				dataType:"json"
			});		
		}
		
	},
	success: function(label) {
		// set &nbsp; as text for IE
		label.html("&nbsp;").addClass("form_label_success");
		//alert( label.parent().last().html() );
		//alert( label.parent().html() );
	},
	errorPlacement: function(error, element) {
		if (element.attr("name") == "item_type")
			error.insertAfter("#adv_radio_cnt");
		else
			error.insertAfter(element);
	}

});



/*
$('#map_container').on('click', function(){
	//open pop up here	
});
*/

});






//95 62 49 01 59

var map;
var markerLatLng = null;
var iZoom = parseInt($('#zoom').val());
function initMap(initialLatlng, initialZoom) {
	
	
	var defaultLatlng = {lat: 8.524, lng: 76.935};
	console.log(JSON.stringify(defaultLatlng));
	
	myLatlng = initialLatlng ? initialLatlng : defaultLatlng;
	iZoom = initialZoom ? initialZoom : 12;
	
	console.log(JSON.stringify(myLatlng));
	
	
	map = new google.maps.Map(document.getElementById('map'), {
		center: myLatlng,
		zoom: initialZoom
	});
  
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		draggable:true,
		title: 'Drag to your location'
	});
	
	
	
	marker.addListener('dragend', function() {
		
		// add value to form field
		markerLatLng = marker.getPosition();
		
		// add value for user preview
		$('#lat_long_preview').html(markerLatLng.H.toFixed(3) + ", " + markerLatLng.L.toFixed(3));
		
		//We display the button to select the current position only now.
		$('#select_position').show();
	});
  
}




$(document).ready(function() {
	
	
	$("#mark_location").fancybox({
		fitToView	: false,
		width		: '500',
		height		: '500',
		autoSize	: true,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		scrolling 	: 'no',
		afterShow 	: function() {
			
			var startingLatLong = null;
			var startingZoom = $('#zoom').val();
			
			if( $('latitude').val() && $('longitude').val() ) {
				startingLatLong = {lat: $('latitude').val(), lng: $('longitude').val()};
			}
			
			initMap(startingLatLong, startingZoom);
		}
	});
	
	
	$('#select_position').on('click', function(event){
		
		if( markerLatLng != null ) {
			
			
			
			$('#latitude').val(markerLatLng.H);
			$('#longitude').val(markerLatLng.L);
			$('#zoom').val(iZoom);
			
			//display the currently selected location to the user
			$('#current_selected_location').html( markerLatLng.H + ", " + markerLatLng.L );
			
			// change text of button
			$('#mark_location').html('Change this address')
			
			$.fancybox.close();
			
			
			
		}
		
		event.preventDefault();
	});
	
	
	
	
});


/*
var geocoder = new google.maps.Geocoder();

geocoder.geocode({
		location: {lat: 8.5031589, lng: 76.9389645}
	});

*/



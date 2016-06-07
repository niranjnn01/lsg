


var map;
var markerLatLng = null;
var iZoom = parseInt($('#zoom').val());

function initMap(initialLatlng, initialZoom) {
	
	
	var defaultLatlng = {lat: 8.524, lng: 76.935};
	//console.log(JSON.stringify(defaultLatlng));
	
	myLatlng = initialLatlng ? initialLatlng : defaultLatlng;
	iZoom = initialZoom ? initialZoom : 12;
	
	console.log(JSON.stringify(myLatlng));
	console.log(iZoom);
	
	
	map = new google.maps.Map(document.getElementById('map'), {
		center: myLatlng,
		zoom: iZoom
	});
  
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
	});
	
}



$(document).ready(function() {
	
	$(".fancybox_map").fancybox({
		
		fitToView	: false,
		width		: '500',
		height		: '500',
		autoSize	: true,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		scrolling 	: 'no',
		afterShow 	: function() {
			
			
			//console.log( $(this.element).attr('data-lat') );
			// console.log(JSON.stringify(this.element[0]));
			
			var latitude 	= $(this.element).attr('data-lat');
			var longitude 	= $(this.element).attr('data-long');
			var zoom 		= $(this.element).attr('data-zoom');
			
			
			var startingLatLong = null;
			var startingZoom = parseInt(zoom);
			
			startingLatLong = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
			
			
			initMap(startingLatLong, startingZoom);
		}
	});
	
});

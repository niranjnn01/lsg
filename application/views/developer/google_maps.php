<!DOCTYPE html>
<html>
  <head>
    <style type="text/css">
		
      html, body { height: 100%; margin: 0; padding: 0; }
      
	  #map { height: 500px; width: 500px; position: relative; left:-1000px;}
	  
    </style>
  </head>
  <body>
	
	<br/><br/>
	
	<a href="#" id="show_map">Show Map</a>
	
	
	
    <div id="map"></div>
	
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript">

	$(document).ready(function(){
		$('#show_map').on('click', function (event) {
			
			$('#map').css('left',0);
			
			event.preventDefault();
		});
	});
	
	
var map;
var marketLatLng = null;
function initMap() {
	/*
	var myLatlng = {lat: 8.524, lng: 76.935};
	
	map = new google.maps.Map(document.getElementById('map'), {
		center: myLatlng,
		zoom: 12
	});
  
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		draggable:true,
		title: 'Drag to your location'
	});
	
	
	
	marker.addListener('dragend', function() {
		
		marketLatLng = marker.getPosition();
	});
  */
	
	var geocoder;
	geocoder = new google.maps.Geocoder();
	
	geocoder.geocode( {location: {lat: 8.5031589, lng: 76.9389645}}, function(results, status) {
      
	  if (status == google.maps.GeocoderStatus.OK) {
        //map.setCenter(results[0].geometry.location);
		
		console.log(JSON.stringify(results));
		
			/*
			var marker = new google.maps.Marker({
			    map: map,
			    position: results[0].geometry.location
			});
			*/
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
	
}

    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBW9TCEGLPvtTY7Bukw034WrRTEeJfpFGQ&callback=initMap&language=en">
    </script>



  </body>
</html>




















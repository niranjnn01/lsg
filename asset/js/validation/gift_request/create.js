
		var oGiftItemsJsonObj = $.parseJSON( $('#gift_items_json_string').val() );
		
		
		
		function addGiftItem(gift_item_id, required_number) {
			
            
            
			var oGiftItemsJsonObj = $.parseJSON( $('#gift_items_json_string').val() );
			
            var selected_gift_items;
            
            if( $('#selected_gift_items_json_string').val() == '' ) {
                
                
                selected_gift_items = {};
                
            } else {
                
                
                selected_gift_items = $.parseJSON( $('#selected_gift_items_json_string').val() );
                
            }
			
            
            
            
            
            var bUpdateItemInList = false;
            
            
            
			if( selected_gift_items.hasOwnProperty( gift_item_id ) ) {
				
                bUpdateItemInList = true;
                
            
            	selected_gift_items[gift_item_id]['num_required'] = required_number;
                selected_gift_items[gift_item_id]['num_received'] = 0;
                
                
			} else {
                
            
                
                selected_gift_items[gift_item_id] = {};
                
                selected_gift_items[gift_item_id]['num_required'] = required_number;
                selected_gift_items[gift_item_id]['num_received'] = 0;
            }
			
            
            
			// visual action that is required
            if( bUpdateItemInList ) {
                updateGIftItemToList(gift_item_id, required_number, oGiftItemsJsonObj);
            } else {
                
                addGIftItemToList(gift_item_id, required_number, oGiftItemsJsonObj);
            }
			
            
            console.log(JSON.stringify(selected_gift_items));
            
            
            // update information to hidden form field
			
			$('#selected_gift_items_json_string').val(JSON.stringify(selected_gift_items));
			// get reflected in form
			
		}
		
		
		function removeGiftItem(gift_item_id) {
			
			//get current state from form
			
            var selected_gift_items;
            
            if( $('#selected_gift_items_json_string').val() == '' ) {
				
			    selected_gift_items = {};
                
            } else {
                selected_gift_items = $.parseJSON( $('#selected_gift_items_json_string').val() );
            }
			
			
			//make changes to the data
			delete selected_gift_items[gift_item_id];
			
			//update back to the form
			$('#selected_gift_items_json_string').val(JSON.stringify(selected_gift_items));
			
			//do the visual action that is required
			$('#selected_item_visual_' + gift_item_id).remove();
			
		}
		
		function addGIftItemToList(gift_item_id, required_number, oGiftItemsJsonObj) {
			$(
                '<div class="row" id="selected_item_visual_' + gift_item_id + '">' + 
                    '<div class="col-md-10">' + 
                        oGiftItemsJsonObj[gift_item_id].title + 
                    '</div>' +
                    '<div class="col-md-1">' + required_number + '</div>' +
                    '<div class="col-md-1">' +
					'<a href="#" class="remove_gift_item" rel="' + gift_item_id + '">x</a>' +
					'</div>' +
                '</div>'
			).prependTo('#selected_gifts_cnt');
		}
        
        
        
		function updateGIftItemToList(gift_item_id, required_number, oGiftItemsJsonObj) {
            
            //console.log('#selected_item_visual_' + gift_item_id);
            
            $('#selected_item_visual_' + gift_item_id).replaceWith(
                '<div class="row" id="selected_item_visual_' + gift_item_id + '">' + 
                    '<div class="col-md-10">' + 
                        oGiftItemsJsonObj[gift_item_id].title + 
                    '</div>' +
                    '<div class="col-md-1">' + required_number + '</div>' +
                    '<div class="col-md-1">' +
					'<a href="#" class="remove_gift_item" rel="' + gift_item_id + '">x</a>' +
					'</div>' +
                '</div>'
            );
            
		}
        
        

$(document).ready(function(){
	
	
	$("#giftRequestCreateForm").validate({
		rules: {
			 title: {required:true},
			 description: {required:true},
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
	
	
	
	$('#add_gift').on('click', function(event) {
		
		var gift_item_id = 0;
		var gift_items_nos = 0;
		
		gift_item_id 	= $('#selected_gift_item').val();
		gift_items_nos 	= $('#gift_items_nos').val();
		
        if( ! isNaN( gift_items_nos ) && gift_items_nos > 0 ) {
            
            //console.log('calling addGiftItem');
            addGiftItem(gift_item_id, gift_items_nos);
            
            // clear the gifts number field
            $('#gift_items_nos').val('');
        }
		
		event.preventDefault();
		
	});
	
	
	$('#selected_gifts_cnt').on('click', '.remove_gift_item', function(event) {
		
		var gift_item_id = 0;
		
		gift_item_id = $(this).attr('rel');
		
		//console.log(gift_item_id);
		removeGiftItem(gift_item_id);
		
		//console.log('test');
		event.preventDefault();
		
	});
    
    
    $('#organization').on('change',function() {
        
        var organization_id = $(this).val();
        
        //console.log(organization_id);
            
        var url = base_url + 'collection_point/get_collection_points_ajax/' + organization_id;
        $.post(
                url,{},
                function ( data ) {
                    if( data.success == 1 ) {
                    
                        //console.log(JSON.stringify(data));
                        $('#collection_point').html('');
                        $.each(JSON.parse(data.page), function(key, value) {
                            //console.log(key);
                            $('<option value="'+ key +'">'+ value +'</option>').appendTo('#collection_point');
                        });
                        
                        
                        $('#collection_point_cnt').show();
                    }
                },
                'json'
            );
        
        
    });
	
    
	
});
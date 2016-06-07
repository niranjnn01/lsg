
		var oGiftItemsJsonObj = $.parseJSON( $('#gift_items_json_string').val() );
		
		
	function getCurrentlySelectedItems() {
            
            var selected_gift_items;
            
            if( $('#selected_gift_items_json_string').val() == '' ) {
                
                selected_gift_items = {};
                
            } else {
                
                //console.log('SELEECED ITEMS ' + $('#selected_gift_items_json_string').val());
                selected_gift_items = $.parseJSON( $('#selected_gift_items_json_string').val() );
                
            }
            
            return selected_gift_items;
        }
        
	function addGiftItem(gift_item_id, num_required, num_received) {
			
            
            //console.log('here');
            
	    var oGiftItemsJsonObj = $.parseJSON( $('#gift_items_json_string').val() );
			
            var selected_gift_items = getCurrentlySelectedItems();
            
            var bNewItem = true;
            
            if( ! selected_gift_items.hasOwnProperty( gift_item_id ) ) {
            
                selected_gift_items[gift_item_id] = {};    
            
            }
	    
	    //console.log(gift_item_id);
            
            selected_gift_items[gift_item_id]['gift_item_title']    = oGiftItemsJsonObj[gift_item_id].title;
            selected_gift_items[gift_item_id]['num_required']       = num_required;
            selected_gift_items[gift_item_id]['num_received']       = num_received;
            
	    console.log(JSON.stringify(selected_gift_items));
            
            // update information to hidden form field
            $('#selected_gift_items_json_string').val(JSON.stringify(selected_gift_items));
            
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
	    
	    console.log(JSON.stringify(selected_gift_items));
	    
	    //update back to the form
	    $('#selected_gift_items_json_string').val(JSON.stringify(selected_gift_items));
	    
	    //do the visual action that is required
	    $('#selected_item_visual_' + gift_item_id).remove();
		
	}
	
	
	function addGIftItemToList(gift_item_id, num_required, num_received, oGiftItemsJsonObj) {
	    
	    $(
		'<div class="row" id="selected_item_visual_' + gift_item_id + '">' + 
		    '<div class="col-md-5">' + 
			oGiftItemsJsonObj[gift_item_id].title + 
		    '</div>' +
		    
		    
		    '<div class="col-md-3 form-inline">' +
		    '<label>Requested</label> <input type="text" id="num_required_'+ gift_item_id +'" data-gift-item-id="'+ gift_item_id +'" class="form-control gift_item_particulars" style="width:55px;" name="num_required_' + gift_item_id + '" value="'+ num_required +'"/>' +
		    '</div>' +
		    
		    
		    '<div class="col-md-3 form-inline">' +
		    '<label>Received</label> <input type="text" id="num_received_'+ gift_item_id +'" data-gift-item-id="'+ gift_item_id +'" class="form-control gift_item_particulars" style="width:55px;" name="num_received_' + gift_item_id + '" value="'+ num_received +'"/>' +
		    '</div>' +
		    
		    
		    '<div class="col-md-1">' +
					'<a href="#" class="remove_gift_item" rel="' + gift_item_id + '">x</a>' +
					'</div>' +
		'</div>'
	    ).prependTo('#selected_gifts_cnt');
	}
    
        
        /*
		function updateGIftItemToList(gift_item_id, num_required, num_received, oGiftItemsJsonObj) {
            
            //console.log('#selected_item_visual_' + gift_item_id);
            
            $('#selected_item_visual_' + gift_item_id).replaceWith(
                
                '<div class="row" id="selected_item_visual_' + gift_item_id + '">' + 
                    '<div class="col-md-10">' + 
                        oGiftItemsJsonObj[gift_item_id].title + 
                    '</div>' +
                    
                    
                    '<div class="col-md-3">' +
                    '<label>Requested</label> <input type="text" class="form-control" name="num_required_' + gift_item_id + '" value="'+ num_required +'"/>' +
                    '</div>' +
                    
                    
                    '<div class="col-md-3">' +
                    '<label>Received</label> <input type="text" class="form-control" name="num_received_' + gift_item_id + '" value="'+ num_received +'"/>' +
                    '</div>' +
                    
                    
                    '<div class="col-md-1">' +
					'<a href="#" class="remove_gift_item" rel="' + gift_item_id + '">x</a>' +
					'</div>' +
                '</div>'
            );
            
		}
        */
        

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
		},
		submitHandler: function(form) {
		    
		    sync_selected_gift_items_to_form();
		}
		
	});
	
	
	
	$('#add_gift').on('click', function(event) {
	    
	    var gift_item_id = 0;
	    var gift_items_nos = 0;
	    var gift_items_received_nos = 0;
	    
	    gift_item_id 	= $('#selected_gift_item').val();
	    gift_items_nos 	= $('#gift_items_nos').val();
	    
	    
	    var selected_gift_items = getCurrentlySelectedItems();
	    
	    if( selected_gift_items.hasOwnProperty( gift_item_id ) ) {
		
		alert("Item aready added.\n update the list below");
		bNewItem = false;
		
	    } else {
		
		if( ! isNaN( gift_items_nos ) && gift_items_nos > 0 ) {
		    
		    addGiftItem(gift_item_id, gift_items_nos, gift_items_received_nos);
		    
		    // clear the gifts number field
		    $('#gift_items_nos').val('');
		    
		    // visual action that is required
		    addGIftItemToList(gift_item_id, gift_items_nos, gift_items_received_nos, oGiftItemsJsonObj);
		    
		}
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
	
    
    $('#selected_gifts_cnt').on('change', '.gift_item_particulars', function (event){
        
    	var gift_item_id = 0;
		
	gift_item_id = $(this).attr('data-gift-item-id');
        num_required = $('#num_required_' + gift_item_id).val();
        num_received = $('#num_received_' + gift_item_id).val();
        
	console.log(gift_item_id);
        console.log(num_required);
        console.log(num_received);
	
        addGiftItem(gift_item_id, num_required, num_received);
        /*
        console.log(gift_item_id);
        console.log(num_required);
        console.log(num_received);
        */
        //updateGIftItemToList(gift_item_id, num_required, num_received, oGiftItemsJsonObj);
    });
    
    
    function sync_selected_gift_items_to_form() {
	
	
	$('#selected_gifts_cnt input[type=text]').each(function (key, value){
	    
	    var gift_item_id = $(value).attr('data-gift-item-id');
	    
	    var num_required = $('num_required_' + gift_item_id).val();
	    var num_received = $('num_received_' + gift_item_id).val();
	    
	    addGiftItem(gift_item_id, num_required, num_received);
	});
    }
    
});
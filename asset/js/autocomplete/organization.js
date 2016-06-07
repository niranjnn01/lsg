

$(function() {

    var selected_organizations_array = new Array();
    
    if( $('#selected_organizations').val() != '' ) {
        selected_organizations_array = $.makeArray( $.parseJSON($('#selected_organizations').val()) );
    }
    
    var users = <?php echo $organization_data;?>;
    
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
    
    $( "#organization_typeahead" )
    // don't navigate away from the field on tab when selecting an item
    .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
            event.preventDefault();
        }
    })
        .autocomplete({
                
        minLength: 0,
        source: function( request, response ) {
          // delegate back to autocomplete, but extract the last term
          response( $.ui.autocomplete.filter(
            users, extractLast( request.term ) ) );
        },
        focus: function( event, ui ) {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
            
            var terms = split( this.value );
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.full_name );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( ", " );
            
            selected_organizations_array.push( ui.item.uid );
            $('#selected_organizations').val( JSON.stringify(selected_organizations_array) );
            
            //add selected item to the container for the user to see
            $('#selected_organizations_cnt').append(
                                            '<div class="alert alert-success" style="float:left;margin-right: 10px;">' +
                                            '<button class="close" id="' + ui.item.uid + '" data-dismiss="alert" type="button">&times;</button>' +
                                            '<a href="' + '<?php echo $base_url, "organization/view/"; ?>' + ui.item.uid + '" target="_blank">' +
                                            ui.item.label +
                                            '</a>' +
                                            '</div>'
                                        );
            
            //clear the input area where we are typing
            this.value = '';
            
            //console.log( $('#selected_organizations').val() );
            
            
          return false;
        }
    })
      
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<img class='m-r-10' src='" + item.profile_pic + "'/><a>" + item.full_name + "</a>" )
        .appendTo( ul );
    };
    

    $('#selected_organizations_cnt').on('click', '.close', function (event) {
        
        var organization_id = $(this).attr('id');
        
        //remove from the array
        for (var key in selected_organizations_array) {
            if (selected_organizations_array[key] == organization_id) {
                selected_organizations_array.splice(key, 1);
            }
        }
        
        $('#selected_organizations').val( JSON.stringify(selected_organizations_array) );
        
    });
    
});

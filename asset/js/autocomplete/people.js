

$(function() {

    var selected_peoples_array = new Array();
    
    if( $('#selected_peoples').val() != '' ) {
        selected_peoples_array = $.makeArray( $.parseJSON($('#selected_peoples').val()) );
    }
    
    var users = <?php echo $people_data;?>;
    
    function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
    
      
    $( "#people_typeahead" )
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
            
            /*
            var terms = split( this.value );
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.full_name );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( ", " );
            */
            
            
                if( $.inArray(ui.item.acc_no, selected_peoples_array) < 0 ) {
                    
                    selected_peoples_array.push( ui.item.acc_no );

                    
                    //the visual action required on select
                            $('#selected_peoples_cnt').append(
                                '<div class="alert alert-success" style="float:left;margin-right: 10px;">' +
                                '<button class="close" id="' + ui.item.acc_no + '" data-dismiss="alert" type="button">&times;</button>' +
                                '<a href="' + '<?php echo $base_url, "profile/view/"; ?>' + ui.item.acc_no + '" target="_blank">' +
                                ui.item.full_name +
                                '</a>' +
                                '</div>'
                            );
                            
                    
                    
                    
                    $('#selected_peoples').val( JSON.stringify( selected_peoples_array ) );
                    //console.log(selected_resources_array);
                }
            this.value = '';
            
            //selected_peoples_array.push( ui.item.acc_no );
            //$('#selected_peoples').val( JSON.stringify(selected_peoples_array) );
            
            //console.log( $('#selected_peoples').val() );
          return false;
        }
    })
      
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<img class='m-r-10' src='" + item.profile_pic + "'/><a>" + item.full_name + "</a>" )
        .appendTo( ul );
    };
    
    

    $('#selected_peoples_cnt').on('click', '.close', function (event) {
        
        var people_id = $(this).attr('id');
        
        //remove from the array
        for (var key in selected_peoples_array) {
            if (selected_peoples_array[key] == people_id) {
                selected_peoples_array.splice(key, 1);
            }
        }
        
        $('#selected_peoples').val( JSON.stringify(selected_peoples_array) );
        
    });
    
});

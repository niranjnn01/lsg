

$(function() {
  
    
    var users = <?php echo $people_data;?>;
    
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
                
            //the visual action required on select
            $('#author_cnt').html(
                
                '<a href="' + '<?php echo $base_url, "profile/view/"; ?>' + ui.item.acc_no + '" target="_blank">' +
                ui.item.full_name +
                '</a>'
            );
                
            $('#selected_peoples').val( ui.item.acc_no );
               
            this.value = '';
            
            return false;
        }
    })
        
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<img class='m-r-10' src='" + item.profile_pic + "'/><a>" + item.full_name + "</a>" )
        .appendTo( ul );
    };
    
    

    $('#author_cnt').on('click', '.close', function (event) {
        
        var people_id = $(this).attr('id');
        
        $('#selected_peoples').val( '' );
        
        
    });
    
});



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
                
                '<img class="thumbnail" src="' + ui.item.profile_pic + '"/><a href="' + '<?php echo $base_url, "profile/view/"; ?>' + ui.item.acc_no + '" target="_blank">' +
                ui.item.full_name +
                '</a><hr>'
            );
                
            $('#selected_peoples').val( ui.item.acc_no );
               
            //show the field set
            $('#fieldset').collapse('show');
            
            //clear the fieldset of any previous data
            $('#fieldset .form-control').val('');
            $('#fieldset [name="payment_date_day"]').val('');
            $('#fieldset [name="payment_date_month"]').val('');
            $('#fieldset [name="payment_date_year"]').val('');
            $('#fieldset [name="excempt_from_commitment"]').removeAttr('checked');
            
            //alert(ui.item.is_supporter);
            
            if( ui.item.is_supporter == '1' ) {
            //if( true ) {
               
               $('#excempt_from_commitment_cnt').collapse('show');
            }
            
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

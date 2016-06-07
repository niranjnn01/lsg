

var valuePresentInSearchList = false;

$(function() {
    
    var selector = '.country_typeahead';
    $(document).on('keydown.autocomplete', selector, function() {
        
        $( this )
        .autocomplete({
            
            minLength: 2,
            source: "<?php echo $base_url, 'type_ahead/country_get';?>",
            select: function( event, ui ) {
                    
                //the visual action required on select
                //alert( ui.item.value );
                //alert(ui.item.id);
                $(this).val(ui.item.id);
                if( ui.item.code ){
                    
                    console.log( $(this).next() );
                    
                    $(this).next().val(ui.item.code);
                    console.log( $(this).next().val() );
                    
                    //$( '#' + $(this).attr('data-target-id') ).val(ui.item.code);
                    //$("#country_code_hidden").val(ui.item.code);   
                }
                
                
            }
        })
            
        // rendering of each item in the list
        
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            .append( "<a>" + item.label + "</a>" )
            .appendTo( ul );
        };
        
    });
    
    // validating the user input, to make sure they select only from the type ahead field
    $( ".country_typeahead" ).autocomplete({
        change: function( event, ui ) {
            
            
            
            if( ui.item == null ) {
                $(this).val('');
            } else {
                
            }
            
        }
    });
    

});

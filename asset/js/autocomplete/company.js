

var valuePresentInSearchList = false;

$(function() {
    
    
    $( "#company_typeahead" )
    .autocomplete({
                
        minLength: 2,
        source: "<?php echo $base_url, 'type_ahead/company_get';?>",
        select: function( event, ui ) {
                
            //the visual action required on select
            //alert( ui.item.value );
            //alert(ui.item.id);
            $("#company_hidden").val(ui.item.id);
            
        }
        
        
    })
        
    // rendering of each item in the list
    
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.label + "</a>" )
        .appendTo( ul );
    };
    
    // validating the user input, to make sure they select only from the type ahead field
    $( "#company_typeahead" ).autocomplete({
        change: function( event, ui ) {
            
            
            
            if( ui.item == null ) {
                $(this).val('');
            } else {
                
            }
            
        }
    });
    

});

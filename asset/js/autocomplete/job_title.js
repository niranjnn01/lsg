

var valuePresentInSearchList = false;

$(function() {
    
    
    $( "#job_title_typeahead" )
    .autocomplete({
                
                
        minLength: 2,
        source: "<?php echo $base_url, 'type_ahead/job_title_get';?>",
        select: function( event, ui ) {
                
            //the visual action required on select
            $("#job_title_hidden").val(ui.item.id);
        }
        
        
    })
        
    // rendering of each item in the list
    
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
        
        //console.log( JSON.stringify(item) );
      return $( "<li>" )
        .append(    "<div>" + item.label + "</div>" +
                    "<div style=\"padding-left:10px;\"><small><em>" + item.description + "</em></small></div>"
        )
        .appendTo( ul );
    };
    
    // validating the user input, to make sure they select only from the type ahead field
    $( "#job_title_typeahead" ).autocomplete({
        change: function( event, ui ) {
            
            
            
            if( ui.item == null ) {
                $(this).val('');
            } else {
                
            }
            
        }
    });
    

});

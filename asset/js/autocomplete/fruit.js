





$(document).ready(function() {
    
    
    $( "#fruit_typeahead" )
    // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
    .autocomplete({
        source: function( request, response ) {
          $.getJSON( "<?php echo $base_url, 'type_ahead/fruit_get';?>", {
            term: extractLast( request.term )
          }, response );
        },
        search: function() {
          // custom minLength
          var term = extractLast( this.value );
          if ( term.length < 2 ) {
            return false;
          }
        },
        focus: function() {
          // prevent value inserted on focus
          return false;
        },
        select: function( event, ui ) {
            
            
            
            
        $("#fruit_id").val(ui.item.id);
            
            
          /*
          var terms = split( this.value );
          // remove the current input
          terms.pop();
          
            if( $.inArray(ui.item.value, terms) < 0 ) {
                    
                // add the selected item
                terms.push( ui.item.value );
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( ", " );
            } else {
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( ", " );
            }
          
          
          
          
          return false;
          */
        }
        
        
    })
        
    // rendering of each item in the list
    
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.label + "</a>" )
        .appendTo( ul );
    };
    
    // validating the user input, to make sure they select only from the type ahead field
    
     $( "#fruit_typeahead" ).autocomplete({
        
        change: function( event, ui ) {
            
            
            if( ui.item == null ) {
                $(this).val('');
            } else {
                
            }
            
        }
    });
    
    
    
     $('#selected_fruits_cnt').on('click', '.close', function (event) {
        
        var fruit_id = $(this).attr('id');
        
        //remove from the array
        for (var key in selected_fruits) {
            
            if (selected_fruits[key] == fruit_id) {
                selected_fruits.splice(key, 1);
            }
        }
        
        $('#selected_fruits').val( JSON.stringify(selected_fruits) );
        
    });

});

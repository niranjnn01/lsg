





$(document).ready(function() {
    
    
    $( "#certificate_typeahead" )
    // don't navigate away from the field on tab when selecting an item
      .bind( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      })
    .autocomplete({
        source: function( request, response ) {
          $.getJSON( "<?php echo $base_url, 'type_ahead/certificate_get';?>", {
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
        }
        
        
    })
        
    // rendering of each item in the list
    
    .autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.label + "</a>" )
        .appendTo( ul );
    };
    
    // validating the user input, to make sure they select only from the type ahead field
    
     $( "#certificate_typeahead" ).autocomplete({
        
        change: function( event, ui ) {
            
            if( ui.item == null ) {
                var terms = split( this.value );
                // remove the current input
                terms.pop();
                // add placeholder to get the comma-and-space at the end
                terms.push( "" );
                this.value = terms.join( ", " );
                //$(this).val('');
            } else {
                
            }
            
        }
    });
    
    
    
     $('#selected_certificates_cnt').on('click', '.close', function (event) {
        
        var certificate_id = $(this).attr('id');
        
        //remove from the array
        for (var key in selected_certificates) {
            
            if (selected_certificates[key] == certificate_id) {
                selected_certificates.splice(key, 1);
            }
        }
        
        $('#selected_certificates').val( JSON.stringify(selected_certificates) );
        
    });

});

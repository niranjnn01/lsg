$(document).ready(function(){
    
        $('#rag_cateogries').typeahead([
        {
        name: 'rag_cateogries',
        local: [ <?php echo $sRagCategories;?> ]
        }
        ]);
        
        $('#rag_places').typeahead([
        {
        name: 'rag_places',
        local: [ <?php echo $sPlaces;?> ]
        }
        ]);
        
        
        
    });

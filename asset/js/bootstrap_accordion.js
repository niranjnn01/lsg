

$(document).ready(function() {
    
    $('.panel-group .panel-collapse').on('hidden.bs.collapse', function () {
       $(this).prev().find(".fa").removeClass("fa-angle-down").addClass("fa-angle-right");
    })    
    $('.panel-group .panel-collapse').on('shown.bs.collapse', function () {
        
       $(this).prev().find(".fa").removeClass("fa-angle-right").addClass("fa-angle-down");
    })
    

    
});

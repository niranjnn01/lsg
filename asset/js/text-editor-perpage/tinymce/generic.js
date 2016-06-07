$(document).ready(function() {
tinyMCE.baseURL = "<?php echo $base_url;?>asset/js/tinymce/jscripts/tiny_mce/";
tinyMCE.init({
        mode : "textareas",
		// General options
		theme : "advanced",
		plugins : "autolink,lists",

		<?php echo $tinymce_button_collection_1;?>

		theme_advanced_toolbar_location : "<?php echo $tinymce_theme_advanced_toolbar_location;?>",
		theme_advanced_toolbar_align : "<?php echo $tinymce_theme_advanced_toolbar_align;?>",
		theme_advanced_statusbar_location : "<?php echo $tinymce_theme_advanced_statusbar_location;?>",
		theme_advanced_resizing : <?php echo $tinymce_theme_advanced_resizing;?>,
		theme_advanced_resizing_use_cookie : false
});

});

<?php //displayHeading('use your facebook profile image', 'heading3');?>
<div class="view_container profile_pic_popup_form">

	<div class="fro" align="center">
		<label>
			<div id="preview_cont_facebook"><?php echo getFbImage($oUser, array('size' => 'normal'));?></div>
		</label>
			
		<div>&nbsp;&nbsp;&nbsp;</div>
		<div class="fr">&nbsp;</div>
	</div>
	
	
	<div class="r m-t-10 fw">
		<input type="button" class="fncybx_cncl_btn btn-default_if r ppc" value="Cancel"/>
		<input type="button" class= "profile_pic_popup_ok r" value="Use This" name="facebook" src=""/>
	</div>
</div>
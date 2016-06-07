<?php //displayHeading('Upload Via URL', 'heading3');?>
<div class="fc profile_pic_url">
	<?php echo form_open('profile/upload_profile_image/url/'.$iAccountNo, 'id = "profilePicPopupUrl" class="c"')?>
		<div class="fro">
			<label>Enter the URL of the image</label>
			<div>&nbsp;:&nbsp;</div>
			<div class="fr">
				<input type="text" name="url"/>
			</div>
		</div>
		<div class="fro">
			<label>&nbsp;</label>
			<div>&nbsp;&nbsp;&nbsp;</div>
			<div class="fr">
				<input type="submit" name="submit" value="Upload Image" id="profile_pic_url_upload_button"/>
			</div>
		</div>
		
	</form>
	<div id="preview_cont_url" class="l">&nbsp;</div>
</div>

<div class="r m-t-10 fw">
		<input type="button" class="fncybx_cncl_btn btn-default_if r ppc" value="Cancel"/>
		<input type="button" class = "profile_pic_popup_ok dn r" value="Use This" name="url"/>
</div>

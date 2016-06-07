
<?php showMessage();?>

<div class="row">
	
	<div class="col-md-3" style="border-right:1px dotted #CCC;">
		
		<div id="preview_cont_upload">
			<?php echo getCurrentProfilePic($oUser, 'normal', true, array(
																	'attributes' => array(
																						  'class'=>'thumbnail',
																						  'strict_dimensions' => true
																						  ),
																	));?>
		</div>
		
	</div>
	
	<div class="col-md-9">
		
		<form class="form-horizontal">
		
			<div class="form-group">
				
				<label class="col-md-3">Click to select an image</label>
				<div  class="col-md-9">
					
					<input type="hidden" id="profile_pic_new_image">
					<a href="#" id="file_upload">Upload Files</a>
					
				</div>
				
			</div>
		
	
			<div class="form-group">
				<label class="col-md-3">&nbsp;</label>
				<div  class="col-md-9">
					<?php echo backButton('profile/edit/'.$oUser->account_no, 'Cancel');?>
					<input type="button" class= "profile_pic_popup_ok dn btn btn-default" value="Use This" name="upload"/>	
				</div>
			</div>
		</form>
		
	</div>
</div>



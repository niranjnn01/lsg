
<?php showMessage();?>



<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<?php echo form_open_multipart('contact_us/submit/' . $form_token, 'id="contactUsForm" class="contus_form form-horizontal"'); ?>
		
		<div class="row">
			<label for="fname" class="control-label">First Name</label>
			<div class="controls">
				<input type="text" name="fname" id="fname" size="30" 
					   class="form-control"
					   value="<?php echo set_value('fname') ? set_value('fname') : '';?>"/>
			</div>
			
		</div>	
		<div class="row">
			<label class="control-label">Last Name</label>
			<div class="controls">
			<input type="text" name="lname" id="lname" size="30" 
				   class="form-control placeholder"
				   value="<?php echo set_value('lname') ? set_value('lname') : '';?>"/>
			</div>	
		</div>	
		<div class="row">
			<label class="control-label">Organization</label>
			<div class="controls">
			<input type="text" name="company" id="company" size="30" 
				   class="form-control placeholder"
				   value="<?php echo set_value('company') ? set_value('company') : '';?>"/>
			</div>	
		</div>	
		<div class="row">
			<label class="control-label">Email ID</label>
			<div class="controls">
			<input type="text" name="email" id="email" size="30" 
				   class="form-control placeholder"
				   value="<?php echo set_value('email') ? set_value('email') : '';?>"/>
			</div>	
		</div>	
		<div class="row">
			<label class="control-label">Phone</label>
			<div class="controls">
			<input type="text" name="phone" id="phone" size="30" 
				   class="form-control placeholder"
				   value="<?php echo set_value('phone') ? set_value('phone') : '';?>"/>
			</div>	
		</div>	
		<div class="row">
			<label class="control-label">Purpose</label>
			<div class="controls">
			<?php echo form_dropdown('contact_us_purpose', $aContactUsPurpose, $iDefaultPurpose, 'class="form-control"');?>
			</div>	
		</div>
		
		<div class="row">
			<label class="control-label">Comment</label>
			<div class="controls m-t-20">
				<textarea name="message" id="message" cols="30" 
				   class="form-control text-editor" rows="10" ><?php echo set_value('message') ? set_value('message') : '';?></textarea>
				<div id="error_placement_comment"></div>
			</div>
		</div>
		
		
		<div class="row">
			<label class="control-label">Enter the characters as seen in the image below </label>
			
			<div class="controls m-t-15">
				<input type="text" id="captcha" name="captcha" class="col-md-12">
				<div class="help-block">The letters are NOT case sensitive.</div>
			</div>
		</div>
		
		<div class="row">
			<label class="control-label">&nbsp;</label>
			<div class="controls m-t-15">
				<div id="captcha_container" class="clearfix m-b-10">
					<?php echo $aCaptcha['image'];?>
					<i id="captcha_refresh" class="captcha_refresh glyphicon glyphicon-refresh" title="refresh captcha image" style="font-size:30px;"></i>
				</div>
				<div id="c"></div>
			</div>
		</div>
		
		
		<div class="row m-t-15">
			<label class="control-label">&nbsp;</label>
			<div class="controls">
				<input type="hidden" value="" id="validated_captcha_code" name="validated_captcha_code">
				<input type="submit" value="Submit" class="form-button btn btn-default btn btn-default-primary">
				<div id="submitting">
					<?php echo c('waiting_gif');?> Sending...
				</div>
			</div>
		</div>	
		</form>
	</div>


</div>
<?php /*?>
    <h3><?php echo $oAddress->title?></h3>
    <?php echo $oAddress->content1;?>
<?php */?>
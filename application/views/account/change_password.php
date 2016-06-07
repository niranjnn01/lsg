<h3><?php echo @$page_heading;?></h3>

<?php showMessage();?>
<?php echo form_open_multipart('account/change_password', array('id' => 'changePasswordForm'))?>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-6 col-md-offset-4">
				
				<div class="row">
					<label class="control-label" for="current_password">Current Password</label>
					<div class="controls">
						<input type="password" value="" id="current_password" name="current_password"/>
					</div>	
				</div>	
				<div class="row">
					<label class="control-label" for="new_password">New Password</label>
					<div class="controls">
						<input type="password" value="" id="new_password" name="new_password"/>
					</div>	
				</div>	
				<div class="row">
					<label class="control-label" for="new_password_confirm">Confirm New Password</label>
					<div class="controls">
						<input type="password" value="" id="password_again" name="password_again"/>
					</div>	
				</div>	
				<div class="row">
					<label class="control-label">&nbsp;</label>
					<div class="controls">
						<input type="submit" value="Change Password" class="btn btn-default btn btn-default-primary"/>
						<?php echo backButton('', 'Back');?>
					</div>	
				</div>	
				
			</div>
		</div>
	</div>
	
	
	
</div>
<?php echo form_close();?>
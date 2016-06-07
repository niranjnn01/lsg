<h3 class="bodyHeading"><?php echo @$page_heading?></h3>
<?php showMessage();?>
<div class="row">

<?php /*?>

	<div class="col-md-12">
		
		<div class="media">
			
			<a href="#" class="pull-left">
				<?php echo getCurrentProfilePic($oUser, 'small', true, array('attributes' => array('class' => 'media-object')));?>
			</a>
			<div class="media-body">
				
				<h4><?php echo $oUser->full_name;?>	</h4>
				<div class="media">
					<a class="" href="<?php echo c('base_url').'profile/edit'?>" title="Edit Profile">Edit Profile</a>
				</div>
				
			</div>
		</div>
		
	</div>
	
	<hr>

	
	<h4>Security</h4>
<?php */?>

	<div class="col-md-12">
		
		
			<a class="linkable" href="<?php echo c('base_url').'account/change_password'?>" title="Change Password">
				Change Password
			</a>
		
	</div>
	
	<?php /*?>
	<h4>Actions</h4>
	
	<?php if(!$bHasUserNamePassword):?>
	<div class="col-md-12">
		
		<a class="linkable" href="<?php echo $c_base_url;?>account/set_username_password">Set a username and password</a>
		
	</div>	
	<?php endif;?>
	
	<?php if (!isAdminLoggedIn()):?>
	<div class="col-md-12">
		
		<a class="linkable" href="<?php echo c('base_url').'account/close'?>" title="Close account and delete all related data">Close account and delete all related data</a>
		
	</div>
	<?php endif;?>
	<?php */?>
	
</div>
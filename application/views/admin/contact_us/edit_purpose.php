
<?php showMessage();?>

<?php echo form_open_multipart('contact_us/edit_purpose/'.$oPurpose->uid, array('id' => 'contactpurposeCreateForm'))?>


<div class="row">
<div class="col-md-8">
	
	<div class="row">
		<label for="title">Title</label>
		<input type="text" name="title"
			   value="<?php echo set_value('title') ? set_value('title') : $oPurpose->title;?>"
			   class="col-md-12"
			   <?php echo ($oPurpose->uid == 1) ? 'disabled="disabled"' :'';?> />
	</div>
    
	<div class="row">
		<label for="description">Description</label>
			
		<textarea name="description" class="col-md-12"><?php echo set_value('description') ? set_value('description') : $oPurpose->description;?></textarea>
	</div>
    
	<div class="row">
		<label for="email">Email</label>
		<input type="text" name="email" class="col-md-12" value="<?php echo set_value('email') ? set_value('email') : $oPurpose->email;?>"/>

	</div>

	<div class="row">
		<label for="reciever_name">Receiever Name</label>
		<input type="text" name="reciever_name" class="col-md-12" value="<?php echo set_value('reciever_name') ? set_value('reciever_name') : $oPurpose->reciever_name;?>"/>
				

	</div>
    
	
	<div class="row">
		<label for="email_template_id">Email Template</label>
                <?php $iDefault = set_value('email_template_id') ? set_value('email_template_id') : $oPurpose->email_template_id;?>
				<?php echo form_dropdown('email_template_id', $aEmailTemplates, $iDefault, ' class="col-md-12"');?>
	</div>
	
	<div class="row">
		<label for="status">Status</label>
				<?php $iDefault = set_value('status') ? set_value('status') : $oPurpose->status;?>
				<?php echo form_dropdown('status', $aPurposeStatus, $iDefault, ' class="col-md-12"');?>
	</div>
    
	<div class="row">
		<label for="success_message">Success Message</label>
		<textarea name="success_message" class="col-md-12"><?php echo set_value('success_message') ? set_value('success_message') : $oPurpose->success_message;?></textarea>
	</div>
	
	
	<div class="row">&nbsp;</div>
	<div class="row">
		<input type="submit" name="update" value="Update" class="btn btn-default btn btn-default-primary"/>
		<?php echo backButton('', 'Back');?>
	</div>
	
</div>
</div>
<?php echo form_close(); ?>
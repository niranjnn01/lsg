<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<?php showMessage();?>
		<div class="form-group text-center">
            <?php if ( ! $this->facebook->is_authenticated()) { ?>
				<div class="login">
            		<a href="<?php echo $this->facebook->login_url(); ?>" class="btn btn-default">Login with Facebook</a>
            	</div>
            <?php }?>
		</div>
	</div>
</div>
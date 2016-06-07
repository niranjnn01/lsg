<div class="row">&nbsp;</div>
<div class="row">

	<div class="col-xs-3" style="border-right:1px dashed #CCC;">
		<?php echo getCurrentProfilePic($oUser, 'normal',true, array('attributes'=>array(
																		'class' => 'thumbnail',
																		'style' => 'margin-left:auto;margin-right:auto;',
																		)
																	 ));?>
		
		<div class="row">
			<div class="col-md-12 text-center">
			<p>
				<?php if( $oUser->facebook_url ):?>
					<a href="<?php echo $oUser->facebook_url;?>" target="_blank" title="facebook" class="p-r-10">
						<i class="fa fa-2x fa-facebook-square"></i>
					</a>
				<?php endif;?>
				<?php if( $oUser->twitter_url ):?>
					<a href="<?php echo $oUser->twitter_url;?>" target="_blank" title="twitter" class="p-r-10">
						<i class="fa fa-2x fa-twitter-square"></i>
					</a>
				<?php endif;?>
				<?php if( $oUser->blog_url ):?>
					<a href="<?php echo $oUser->blog_url;?>" target="_blank" title="blog">
						<i class="fa fa-2x fa-book"></i>
					</a>
				<?php endif;?>
			</p>
			</div>
		</div>
		
		
		<div class="row">
			<div class="col-md-12 text-center">
			    <a href="#write_to_me_cnt" class="fancybox"><i class="fa fa-envelope-o"></i> Write to me</a>
			</div>
        </div>
		<hr/>
		<?php if( $aPrograms ): ?>
		<div class="row">
			<div class="col-md-12">
				<b>Program Director</b>
				<?php foreach( $aPrograms AS $oItem ): ?>
					<ul class="list-unstyled">
						<li>
							<a href="<?php echo $c_base_url, 'program/view/', $oItem->seo_name;?>">
								<?php echo $oItem->title?>
							</a>
						</li>
					</ul>
				<?php endforeach; ?>
			</div>
		</div>
		</hr>
		<?php endif;?>
		
		<?php if( $aCampaigns ): ?>
		<div class="row">
			<div class="col-md-12">
			<b>Campaigner</b>
			<ul class="list-unstyled">
			<?php foreach( $aCampaigns AS $oItem ): ?>
				<li>
					<a href="<?php echo $c_base_url, 'campaign/view/', $oItem->seo_name;?>">
						<?php echo $oItem->title?>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
			</div>
		</div>
		</hr>
		<?php endif;?>
		
		<?php if( $aProjects ): ?>
		<div class="row">
			<div class="col-md-12">
			<b>Program Manager</b>
			<ul class="list-unstyled">
			<?php foreach( $aProjects AS $oItem ): ?>
				<li>
					<a href="<?php echo $c_base_url, 'project/view/', $oItem->seo_name;?>">
						<?php echo $oItem->title?>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
			</div>
		</div>
		<hr/>
		<?php endif;?>
		
		
	</div>
	
	<div class="col-md-9">
		<div class="row">
			<div class="col-md-12">
				
				<h2><?php echo $oUser->full_name;?></h2>
				<h6><i>
					<?php echo $sUserRolesText;?>
				</i></h6>
				<div><?php echo $oUser->about_me;?></div>
				

		<?php if( $aArticles ): ?>
        <hr>
		<div class="row">
			<div class="col-md-12">
			<h4>Articles by <?php echo $oUser->full_name;?></h4>
			<ol class="">
			<?php foreach( $aArticles AS $oItem ): ?>
				<li>
					<a href="<?php echo $c_base_url, 'article/view/', $oItem->seo_name;?>">
						<?php echo $oItem->title?>
					</a>
				</li>
			<?php endforeach; ?>
			</ol>
			</div>
		</div>
		<?php endif;?>
				
				
				
			</div>

		</div>
	</div>
	
</div>
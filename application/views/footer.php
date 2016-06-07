        
        </div>
            </div>
</div>
<!-- end: Container -->
<?php ?>
<!-- start: Footer -->
<div id="footer" style="height:150px;">
	
</div>
<?php ?>
<!-- end: Footer -->

<?php /*?>
<!-- start: Footer menu-->
<section id="footer-menu">
    <div class="container">
        <div class="row">
            <div class="col-md-12 hidden-xs">
                <ul class="pull-right">
                    <li><a href="<?php echo c('base_url');?>user/login">login</a></li>
                    <li><a href="<?php echo c('base_url');?>">Home</a></li>
                    <li><a href="<?php echo c('base_url');?>sitemaps">Sitemap</a></li>
                    <li><a href="<?php echo c('base_url'), 'about_us';?>">About</a></li>
                    <li><a href="<?php echo c('base_url'), 'contact_us';?>">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
<?php */?>
<!-- end: Footer menu-->


<?php if(isset($sGenericContactForm) && $sGenericContactForm):?>
	
			<?php echo $sGenericContactForm;?>

<?php endif;?>


<?php if( $enable_social_buttons ):?>
	<!-- AddThis  BEGIN -->
	<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-514fcd3f71d2a817"></script>
	<!-- AddThis END -->
<?php endif;?>


    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBW9TCEGLPvtTY7Bukw034WrRTEeJfpFGQ&callback=initMap&language=en">
    </script>
    
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<?php echo load_files('js');?>
</body>
</html>
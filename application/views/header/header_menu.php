
<!-- start: Top Menu - New-->
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        
        
      <ul class="nav navbar-nav">
        <li <?php echo ($sCurrentMainMenu == 'home') ? 'class=active' : '';?>>
            <a href="<?php echo $c_base_url;?>" >Home </a>
        </li>
        
        <?php /*?>
        <li <?php echo ($sCurrentMainMenu == 'fruits_database') ? 'class=active' : '';?>>
            <a href="<?php echo $c_base_url;?>fruit" >Fruits Database </a>
        </li>
        <li <?php echo ($sCurrentMainMenu == 'market') ? 'class=active' : '';?>>
            <a href="<?php echo $c_base_url;?>market" >Market </a>
        </li>
        <?php */?>
        
        <?php /*?>
            <li class="dropdown">  
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Programs <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="#">Agriculture and Food Sovereignity</a></li>
                    <li>
                        <a href="#">Sustainable resource use and Management</a>
                    </li>
                </ul>
        </li>
        <?php */?>
      </ul>
      
      
      <ul class="nav navbar-nav navbar-right">
        <li class="">
            <a href="<?php echo $c_base_url;?>about_us" >About </a>
        </li>
        <li>
            <a href="<?php echo $c_base_url;?>contact_us">Contact Us</a>
        </li>
        <li class="">
        	<?php if( $this->authentication->is_user_logged_in() ):?>
            	<a href="<?php echo $c_base_url;?>logout" >Logout</a>
            <?php else:?>
            	<a href="<?php echo $c_base_url;?>user/login" >Login</a>
            <?php endif;?>
            
        </li>
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<?php if( $this->authentication->is_user_logged_in() ):?>
	<div class="pull-right">Welcome <?php echo s('FULL_NAME');?></div>
<?php endif;?>
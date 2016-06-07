<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"><!--<![endif]-->

<head>
	
    <?php if( $bShowOpenGraphMetaDataInPage && isset($og_meta_data) && !empty($og_meta_data)):?>
    
        <meta property="og:app_id" content="<?php echo $og_meta_data['og_app_id']?>" />
        <meta property="og:og_url" 	content="<?php echo $og_meta_data['og_url']?>"/>
        <meta property="og:og_image" content="<?php echo $og_meta_data['og_image']?>"/>
        <meta property="og:og_site_name" content="<?php echo $og_meta_data['og_site_name']?>"/>
        <meta property="og:og_title" content="<?php echo $og_meta_data['og_title']?>"/>
        <meta property="og:og_description" content="<?php echo $og_meta_data['og_description']?>"/>
	
    <?php endif;?>
	
    <title><?php echo isset($page_title)? $page_title : getTitle();?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=100%; initial-scale=1; maximum-scale=1; minimum-scale=1; user-scalable=no;"/>
    <link rel="shortcut icon" href="<?php echo $c_base_url;?>/favicon.ico"/>
    <link rel="apple-touch-glyphicon glyphicon-precomposed" sizes="144x144" href="<?php echo $c_base_url;?>asset/img/apple-touch-glyphicon glyphicon-144-precomposed.png"/>
    <link rel="apple-touch-glyphicon glyphicon-precomposed" sizes="114x114" href="<?php echo $c_base_url;?>asset/img/apple-touch-glyphicon glyphicon-114-precomposed.png"/>
    <link rel="apple-touch-glyphicon glyphicon-precomposed" sizes="72x72" href="<?php echo $c_base_url;?>asset/img/apple-touch-glyphicon glyphicon-72-precomposed.png"/>
    <link rel="apple-touch-glyphicon glyphicon-precomposed" href="<?php echo $c_base_url;?>asset/img/apple-touch-glyphicon glyphicon-57-precomposed.png"/>
    
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <?php echo load_files('css');?>
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

	
	
    <?php // GOOGLE ANALYTICS TRACKING CODE ?>
	
    
    <?php /*?>
    <link rel="stylesheet" type="text/css" href="<?php echo $c_base_url;?>asset/css/themes/misty/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $c_base_url;?>asset/css/themes/misty/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $c_base_url;?>asset/css/themes/misty/css/prettyPhoto.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo $c_base_url;?>asset/css/themes/misty/css/font-awesome.min.css"/>
    <?php */?>
    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo $c_base_url;?>asset/css/themes/misty/css/font-awesome-ie7.min.css"/>
    <![endif]-->

	
    
    <?php /*?>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/jquery.easing.1.3.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/jquery.quicksand.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/superfish.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/hoverIntent.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/jquery.flexslider.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/jflickrfeed.min.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/jquery.prettyPhoto.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/jquery.elastislide.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/jquery.tweet.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/smoothscroll.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/jquery.ui.totop.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/ajax-mail.js"></script>
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/main.js"></script>
    <?php */?>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    
    <?php /*?>
    <link rel="stylesheet" type="text/css" href="<?php echo $c_base_url;?>asset/css/themes/misty/css/layerslider.css" >
    <script type="text/javascript" src="<?php echo $c_base_url;?>asset/js/misty/layerslider.kreaturamedia.jquery.js"></script>
    <?php */?>
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Josefin+Slab:400italic' rel='stylesheet' type='text/css'>
</head>

<body>





<!-- end: Top Menu - New-->




<!-- start: Container -->
<div class="container m-t-5">


<div class="row">
	
	<div class="col-xs-1">
		<div id="" class="hidden-xs ">
			<a href="<?php echo $c_base_url;?>" class="hidden-xs" style="display:block;width:94px;height:120px;">
				<img src="<?php echo $c_static_image_url, c('logo_image_name');?>"
						class="thumbnail"
						alt="<?php echo $c_website_title;?>"/>
			</a>
		</div>
	</div>
	
	<div class="col-xs-11">
		
		<?php /*?>
		<div class="col-xs-12 text-right">
			
			<a href="<?php echo current_url() . '?language=en';?>">
				<?php if( $sLanguage == 'en' ):?>
					<i class="fa fa-check"></i>
				<?php endif?>
				English
			</a>&nbsp;&nbsp;&nbsp;
			
			<a href="<?php echo current_url() . '?language=ml';?>">
				<?php if( $sLanguage == 'ml' ):?>
					<i class="fa fa-check"></i>
				<?php endif?>
				<?php echo $this->lang->line('common_malayalam');?>
			</a>
			
		</div>
		<?php */?>
		
		<div class="col-xs-12 header-nav">
			
			<?php /* dynamically created menu - refer common_model */?>
			<?php $this->load->view('header/header_menu', array('c_base_url' => $c_base_url));?>
			
		</div>
		

	</div>
</div>
<?php $bShowBreadCrums = FALSE;?>

<?php if( $bShowBreadCrums ):?>

    <?php $aExcemptPages = array('home');?>

    <?php if( ! in_array($sCurrentMainMenu, $aExcemptPages)):?>
        <div class="row m-t-5">
            <ol class="breadcrumb">
            <?php //p($aBreadCrumbs);?>
            <?php $iCount = count($aBreadCrumbs);?>
            <?php $iCount = --$iCount;?>
            <?php foreach( $aBreadCrumbs AS $iKey => $aItem ):?>
            <?php
                $sUrl = '';
                if( ($iCount != $iKey)  || ($iCount == 0) ):
                    $sUrl = $c_base_url . $aItem['uri'];
                endif;
            ?>
                <li class="<?php echo !$sUrl ? 'active' : '';?>">
                    
                    <?php if($sUrl):?>
                        <a href="<?php echo $sUrl;?>">
                            <?php echo $aItem['title'];?>
                        </a>
                    <?php else:?>
                        <?php echo $aItem['title'];?>
                    <?php endif;?>
                    
                </li>
            <?php endforeach;?>
            </ol>
        </div>
    <?php endif;?>
    
<?php endif;?>



<div class="row">
	<div class="page-inner">
		<div class="sub-inner">

		
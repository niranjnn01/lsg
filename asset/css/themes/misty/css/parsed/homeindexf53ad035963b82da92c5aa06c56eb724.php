<?php header("Content-type: text/css");$base_path =	'C:/wamp/www/lsg/';
$base_url =	'http://localhost/lsg/';
$password_min_length =	'6';
$contact_us_max_length =	'500';
$static_image_url =	'http://localhost/lsg/asset/img/';
$css_image_url =	'http://localhost/lsg/asset/css/themes/misty/css/img/';
$captcha_img_height =	'';
$css_variables =	array('base_colour' => '#888888','lighter1' => '#918F8F','darker1' => '#545252','link_colour' => '#02923B','link_visited_colour' => '#02923B','font_colour' => '#444444',);
 ?>



.form_label_error{color:red;}.l{float:left;}
.r{float:right;}

.m-5{margin:5px;}
.p-5{padding:5px;}

.m-t-5{margin-top:5px;}
.m-t-10{margin-top:10px;}
.m-t-15{margin-top:15px;}
.m-t-20{margin-top:20px;}

.m-l-5{margin-left:5px;}
.m-l-10{margin-left:10px;}
.m-l-15{margin-left:15px;}
.m-l-20{margin-left:20px;}

.m-b-5{margin-bottom:5px;}
.m-b-10{margin-bottom:10px;}
.m-b-15{margin-bottom:15px;}
.m-b-20{margin-bottom:20px;}

.m-r-5{margin-right:5px;}
.m-r-10{margin-right:10px;}
.m-r-15{margin-right:15px;}
.m-r-20{margin-right:20px;}

.p-t-5{padding-top:5px;}
.p-t-10{padding-top:10px;}
.p-t-15{padding-top:15px;}
.p-t-20{padding-top:20px;}

.p-l-5{padding-left:5px;}
.p-l-10{padding-left:10px;}
.p-l-15{padding-left:15px;}
.p-l-20{padding-left:20px;}

.p-b-5{padding-bottom:5px;}
.p-b-10{padding-bottom:10px;}
.p-b-15{padding-bottom:15px;}
.p-b-20{padding-bottom:20px;}

.p-r-10{padding-right:10px;}
.p-r-15{padding-right:15px;}
.p-r-20{padding-right:20px;}


.tar{text-align:right;}
.tal{text-align:left;}
.tac{text-align:center;}
.taj{text-align:justify;}
.u{text-decoration:underline;}
.cl{clear:left;}
.cr{clear:right;}
.dn{display:none;}
.fw{width:100%;}
.cp{cursor:pointer;}
<?php /*various widths*/?>
.w50{width:50px !important;}
.w60{width:60px !important;}
.w100{width:100px !important;}
.h100{height:100px;}

.pr{
position:relative;
}

<?php /*standard formatting to be applied to any div so that the content will not look bad??*/?>
.sf{padding:4px 5px;}


<?php /*link related settings*/ ?>
.link{color:#006E97;text-decoration:underline;}
.linkable:hover{text-decoration:underline;}

<?php /*horizontal rule*/ ?>
.hr{
background-color: #D2D2D2;
border: 0 none;
height: 1px;
margin: 20px 0;
width:100%;
}

hr.small{
margin: 5px 0;    
}

/*clearfix*/
.c:after {
	visibility: hidden;
	display: block;
	font-size: 0;
	content: " ";
	clear: both;
	height: 0;
	}
.c { display: inline-table; }
/* Hides from IE-mac \*/
* html .c { height: 1%; }
.c { display: block; }
/* End hide from IE-mac */
/*clearfix*/


#sds_results li{margin-bottom:5px;}
#sds_results li h5{margin:0px;}


.table.borderless>tbody>tr>td, .table.borderless>tbody>tr>th {
    border: none;
}
<?php
date_default_timezone_set('UTC');
$LANG = 'pt';
$idv = substr(date("s"), 1, 1);
$idv = '4';
$video = '';
require ("db.php");
require("_class/_class_header_fz.php");
$hd = new header;
echo $hd->head();

$http = "/fz/";
//$http = "/projetos/Fonzaghi_FZ/";

if ($nocab==1)
   {
	    echo '<!DOCTYPE html>
		<html>
		
			<head>
				<meta charset="iso-8859-1">
				<title>Fonzaghi :: INTRANET ::</title>
				<meta charset="ISO-8859-1" description" content="">
				<meta name="description" content="Fonzaghi">
				<link rel="icon" type="img/png" href="favicon.png">
				<link rel="stylesheet" href="'.$http.'css/cicpg-inport-font.css">
				<link rel="stylesheet" href="'.$http.'css/cicpg-header-main.css">
				<link rel="stylesheet" href="'.$http.'css/cicpg_normal.css">
				<link rel="stylesheet" href="'.$http.'css/font-awesome-4.2.0/css/font-awesome.css">
				<link rel="stylesheet" href="'.$http.'css/font-awesome-4.2.0/css/font-awesome.min.css">
				<link rel="stylesheet" href="'.$http.'css/component.css">
				<script src="'.$http.'js/jquery.js"></script>
				<script src="'.$http.'js/scrooling.js"></script>
				<script src="'.$http.'js/jquery.maskedinput.js"></script>
		
				<script src="'.$http.'js/modernizr.custom.js"></script>
				<script src="http://twitterjs.googlecode.com/svn/trunk/src/twitter.min.js" type="text/javascript"></script>
				<script type="text/javascript">
		$(function(){
		$(\'article.tabs section > h3\').click(function(){
		$(\'article.tabs section\').removeClass(\'current\');
		$(this)
		.closest(\'section\').addClass(\'current\');
		});
		});
		</script>
		</head>
		<body>';
		
		
   } else {
        echo '<!DOCTYPE html>
		<html>
		
			<head>
				<meta charset="iso-8859-1">
				<title>Fonzaghi :: INTRANET ::</title>
				<meta charset="ISO-8859-1" description" content="">
				<meta name="description" content="Fonzaghi">
				<link rel="icon" type="img/png" href="favicon.png">
				<link rel="stylesheet" href="'.$http.'css/cicpg-inport-font.css">
				<link rel="stylesheet" href="'.$http.'css/cicpg-header-main.css">
				<link rel="stylesheet" href="'.$http.'css/cicpg_normal.css">
				<link rel="stylesheet" href="'.$http.'css/font-awesome-4.2.0/css/font-awesome.css">
				<link rel="stylesheet" href="'.$http.'css/font-awesome-4.2.0/css/font-awesome.min.css">
				<link rel="stylesheet" href="'.$http.'css/component.css">
				<script src="'.$http.'js/jquery.js"></script>
				<script src="'.$http.'js/scrooling.js"></script>
				<script src="'.$http.'js/jquery.maskedinput.js"></script>
		
				<script src="'.$http.'js/modernizr.custom.js"></script>
				<script src="http://twitterjs.googlecode.com/svn/trunk/src/twitter.min.js" type="text/javascript"></script>
				<script type="text/javascript">
		$(function(){
		$(\'article.tabs section > h3\').click(function(){
		$(\'article.tabs section\').removeClass(\'current\');
		$(this)
		.closest(\'section\').addClass(\'current\');
		});
		});
		</script>
		</head>
		<body>';
		
		require ("cab_top_menu.php");
		echo '
				<script src="'.$http.'js/classie.js"></script>
				<script src="'.$http.'js/gnmenu.js"></script>
				<script>
					new gnMenu(document.getElementById(\'gn-menu\'));
				</script>
		<div style="height:30px"></div>';
   }

	
?>

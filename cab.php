<?php
$LANG = 'pt';
$idv = substr(date("s"), 1, 1);
$idv = '4';
$video = '';
require ("db.php");
require("_class/_class_header_fz.php");
$hd = new header;
echo $hd->head();

?><!DOCTYPE html>
<html>

	<head>
		<meta charset="iso-8859-1">
		<title>Fonzaghi :: INTRANET ::</title>
		<meta charset="ISO-8859-1" description" content="">
		<meta name="description" content="Fonzaghi">
		<link rel="icon" type="img/png" href="favicon.png">
		<link rel="stylesheet" href="/fz/css/cicpg-inport-font.css">
		<link rel="stylesheet" href="/fz/css/cicpg-header-main.css">
		<link rel="stylesheet" href="/fz/css/cicpg_normal.css">
		<link rel="stylesheet" href="/fz/css/font-awesome-4.2.0/css/font-awesome.css">
		<link rel="stylesheet" href="/fz/css/font-awesome-4.2.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="/fz/css/component.css">
		<script src="/fz/js/jquery.js"></script>
		<script src="/fz/js/scrooling.js"></script>
		<script src="/fz/js/jquery.maskedinput.js"></script>

		<script src="/fz/js/modernizr.custom.js"></script>
		<script src="http://twitterjs.googlecode.com/svn/trunk/src/twitter.min.js" type="text/javascript"></script>
		<script type="text/javascript">
$(function(){
$('article.tabs section > h3').click(function(){
$('article.tabs section').removeClass('current');
$(this)
.closest('section').addClass('current');
});
});
		</script>
	</head>

	<body>
		<?
		require ("cab_top_menu.php");
		?>

		<script src="/fz/js/classie.js"></script>
		<script src="/fz/js/gnmenu.js"></script>
		<script>
			new gnMenu(document.getElementById('gn-menu'));
		</script>
<div style="height:30px"></div>

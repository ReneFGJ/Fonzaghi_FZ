<?php
date_default_timezone_set('UTC');
$LANG = 'pt';
$idv = substr(date("s"), 1, 1);
$idv = '4';
$video = '';
require ("db.php");
//require("../_include/sisdoc_debug.php");
require("_class/_class_user.php");
require("_class/_class_header_fz.php");
require("_class/_class_user_perfil.php");
require($include.'sisdoc_autor.php');

$perfil = new user_perfil;

$hd = new header;
$user = new user;
echo $hd->head();
$user->security();
$ss = $user;

$http = "/fz/";
//$http = "/projetos/Fonzaghi_FZ/";

$hd->http = $http;

/*setar  com 1 caso nao queira zerar o cliente na inicialização da pagina*/
if($nocliente==0){
	unset($_SESSION['cad_cliente']);
}

if ($nocab==1)
   {
	    echo '<!DOCTYPE html>
		<html>
		
			<head>
				<meta charset="iso-8859-1">
				<title>Fonzaghi :: INTRANET ::</title>
				<meta charset="ISO-8859-1" CONTENT="3600; URL='.$http.'logout.php>
				<meta name="description" content="Fonzaghi">
				<link rel="icon" type="img/png" href="favicon.png">
				<link rel="stylesheet" href="'.$http.'css/cicpg-inport-font.css">
				<link rel="stylesheet" href="'.$http.'css/cicpg_normal.css">
				<link rel="stylesheet" href="'.$http.'css/font-awesome-4.2.0/css/font-awesome.css">
				<link rel="stylesheet" href="'.$http.'css/font-awesome-4.2.0/css/font-awesome.min.css">
				<link rel="stylesheet" href="'.$http.'css/component.css">
				<script src="'.$http.'js/jquery.js"></script>
				<script src="'.$http.'js/scrooling.js"></script>
				<script src="'.$http.'js/jquery.maskedinput.js"></script>
		
		<script src="'.$http.'js/modernizr.custom.js"></script>
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
		<script>
		$(document).ajaxStart(function(){
			$("#ampulheta").dialog("open");
		});
		
		$(document).ajaxStop(function(){
			$("#ampulheta").dialog("close");
		});
				</script>
		<body>';
		
		
   } else {
        echo '<!DOCTYPE html>
		<html>
		
			<head>
				<meta charset="iso-8859-1">
				<title>Fonzaghi :: INTRANET ::</title>
				<meta charset="ISO-8859-1" CONTENT="3600; URL='.$http.'logout.php>
				<meta name="description" content="Fonzaghi">
				<link rel="icon" type="img/png" href="favicon.png">
				<link rel="stylesheet" href="'.$http.'css/cicpg-inport-font.css">
				<link rel="stylesheet" href="'.$http.'css/cicpg_normal.css">
				<link rel="stylesheet" href="'.$http.'css/font-awesome-4.2.0/css/font-awesome.css">
				<link rel="stylesheet" href="'.$http.'css/font-awesome-4.2.0/css/font-awesome.min.css">
				<link rel="stylesheet" href="'.$http.'css/component.css">
				<script src="'.$http.'js/jquery.js"></script>
				<script src="'.$http.'js/scrooling.js"></script>
				<script src="'.$http.'js/jquery.maskedinput.js"></script>
		
				<script src="'.$http.'js/modernizr.custom.js"></script>
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
		<div id="ampulheta"
				style="width: 100%; height: 100%; 
				position: absolute; 
				top: 0px; left: 0px;
				background-color: #FFFFFF;
				opacity: 0.8;
				z-index: 100;
				display: none;
				"
		>
			<img src="/fz/img/ajax_loader_blue_512.gif" height="80"
			style="left: 45%; top: 30%; position: absolute;">
		</div>
		<script>
			$(document).ajaxStart(function(){
				$("#ampulheta").fadeIn();
			});
			
			$(document).ajaxStop(function(){
				$("#ampulheta").fadeOut("close");
			});
		</script>
		
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

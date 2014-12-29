<?php
$include = '../';
$include_db = '../';
require("db.php");
require("_class/_class_user.php");
//require($include."sisdoc_debug.php");
$user = new user;
require("../_include/_class_form.php");
require("_class/_class_header_fz.php");
$hd = new header;
header("Content-Type: text/html; charset=".$hd->char_set,true);
	$sx = '<!DOCTYPE html>'.chr(13);
	$sx .= '<html lang="pt-BR">'.chr(13);
	$sx .= '<head>'.chr(13);
	$sx .= '<title>::Login:: Fonzaghi</title>'.chr(13);
	$sx .= '<meta http-equiv="Content-Type" content="text/html; charset='.$hd->char_set.'" />'.chr(13);
	$sx .= '<meta name="expires" content="never" />'.chr(13);
	$sx .= '<link rel="shortcut icon" type="img/favicone.png" />'.chr(13);
	$sx .= '<!-- STYLES // -->	'.chr(13);
	$sx .= '<link rel="stylesheet" type="text/css" media="screen" href="'.$hd->http.'css/style_cab.css" />'.chr(13);
	$sx .= '<link rel="stylesheet" type="text/css" media="screen" href="'.$hd->http.'css/style_fonts.css" />'.chr(13);
	$sx .= '<link rel="stylesheet" type="text/css" media="screen" href="'.$hd->http.'css/style_login.css" />'.chr(13);
	$sx .= $hd->js.chr(13);
	$sx .= '</head>'.chr(13);
	$sx .= '<body leftmargin="0" topmargin="0" >'.chr(13);
	$sx .= '
		<div id="cabecalho" class="cabecalho">
			<center>
			<img src="img/_login_logo.png" class="imagem-lampada" />
			</center>
		</div>
		<center>
		';
echo $sx;
echo $user->login();
?>

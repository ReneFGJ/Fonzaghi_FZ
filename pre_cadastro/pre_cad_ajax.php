<?php
$include = '../';
require('cab.php');
$verb = trim($dd[1]);
require("../_class/_class_cadastro_pre.php");
$prex = new cadastro_pre;
switch ($verb)
{
	case '@':
		echo '@@@@@@@@@@@@@';
		break;	
	case 'R':
		echo 'RRRRRRRRRRRRRRRRR';
		break;
	case 'B':
		echo 'BBBBBBBBBBBBBBBB';
		break;	
	case 'X':
		echo 'XXXXXXXXXXXXXXXXX';
		break;		
}
?>

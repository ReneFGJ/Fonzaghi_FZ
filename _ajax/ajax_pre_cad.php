<?php
$include = '../';
$include_db = '../../';
require ('../db.php');
require ("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
$aux = uppercase($dd[0]);
$verb = uppercase($dd[1]);

switch($verb) {
	case 'APROVADO' :
		$pre->salvar_status($aux,'A');
		echo '<script>location.reload();</script>';
		break;
	case 'RECUSADO' :
		$pre->salvar_status($aux,'R');
		echo '<script>location.reload();</script>';
		break;
	case 'EDICAO' :
		$pre->salvar_status($aux,'@');
		echo '<script>location.reload();</script>';
		break;
		
	case 'LISTA_D' :
		echo $pre->lista_status_dia($aux);
		break;
	case 'LISTA_W' :
		echo $pre->lista_status_semana($aux);
		break;		
	case 'LISTA_M' :
		echo $pre->lista_status_mes($aux);
		break;	
	default :
		break;
}
?>
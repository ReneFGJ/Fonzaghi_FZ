<?php
$include = '../';
$include_db = '../../';
require ('../db.php');
require ($include . 'sisdoc_data.php');
require ($include . 'sisdoc_debug.php');
require ($include . '_class_form.php');
require ('../_class/_class_vendas_funcionario.php');
$venda = new vendas_funcionario;

$verb = uppercase($dd[0]);
$aux1 = uppercase($dd[1]);
$aux2 = uppercase($dd[2]);

switch($verb) {
	case 'INSERE' :
		echo $venda->valida_loja($aux1);
		break;
	default:
		break;	
}
?>
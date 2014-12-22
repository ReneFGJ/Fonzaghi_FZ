<?php
require("cab.php");

require($include.'sisdoc_tips.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
require ($include . '_class_form.php');
require ('../_class/_class_acp.php');
require ("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
$acp = new acp;
$form = new form;


$cp = array();
array_push($cp, array('$S11', '', 'CPF', true, True));
array_push($cp, array('$B', '', 'Consultar', False, False));
		

$tela .=  $form -> editar($cp, '');

echo '<h3>Nova consulta a ACP</h3>';
if ($form -> saved > 0) {
	$cpf = $dd[0];
	$acp->include_db.'../../_db/';
	require('../../_db/db_informsystem.php');
	$acp->consulta_curl($cpf);
	$cliente = '';
	$login = $_SESSION['nw_user'];
	$acao = "330 - NOVA CONSULTA ACP CPF $cpf";
	$acao_cod = '330';
	$status = '1';
	require ("../../_db/db_mysql_" . $ip . ".php");
	$pre->inserir_log($cliente, $login, $acao, $acao_cod, $status);
	redirecina('pre_cadastro.php');
}else{
	echo $tela;
}

?>


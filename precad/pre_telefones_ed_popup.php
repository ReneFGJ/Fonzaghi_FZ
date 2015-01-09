<?php
$nocab=1;
require("cab.php");

require($include.'sisdoc_tips.php');
require($include.'sisdoc_data.php');
//require($include.'sisdoc_debug.php');
require ($include . '_class_form.php');
require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
$form = new form;

require("../../_db/db_mysql_".$ip.".php");
$tabela = 'cad_telefone';
$cp = $pre->cp_telefone();

$tela .=  $form -> editar($cp, $tabela);

$cliente = $dd[1];
echo '<h3>Alteração de telefones - consultora('.$cliente.')</h3>';
if ($form -> saved > 0) {
	$id = $dd[0];
	$status = 1;
	$login = $_SESSION['nw_user'];
	$acao = "215 - ATUALIZOU TELEFONE ID ".$id;
	$acao_cod = '215';
	$pre->inserir_log($cliente, $login, $acao,$acao_cod, $status);
	redirecina('pre_telefones.php');
}else{
	echo $tela;
}
?>

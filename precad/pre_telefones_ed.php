<?php
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
	redirecina('pre_telefones.php');
}else{
	echo $tela;
}
?>

<?php
require("cab.php");

require($include.'sisdoc_tips.php');
require($include.'sisdoc_data.php');
//require($include.'sisdoc_debug.php');
require ($include . '_class_form.php');
require ('../_class/_class_acp.php');

$acp = new acp;
$form = new form;
$acp->include_db.'../../_db/';
require('../../_db/db_informsystem.php');
$cp = array();
array_push($cp, array('$S11', '', 'CPF', true, True));
array_push($cp, array('$B', '', 'Consultar', False, False));
		

$tela .=  $form -> editar($cp, '');

echo '<h3>Nova consulta a ACP</h3>';
if ($form -> saved > 0) {
	$cpf = $dd[0];
	$acp->consulta_curl($cpf);
	redirecina('pre_cadastro.php');
}else{
	echo $tela;
}

?>


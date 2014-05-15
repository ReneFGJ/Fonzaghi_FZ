﻿<?php
require('cab.php');

require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
require('../_class/_class_acp.php');
require($include.'_class_form.php');
$form = new form;

$form->required_message = 0;
$form->required_message_post = 0;
$form->class_string = 'precad_form_string';
$form->class_string = 'precad_form_string';
$form->class_button_submit = 'precad_form_submit';
$form->class_form_standard = 'precad_form';
$form->class_memo = 'precad_form';

$cp = $pre->cp_00();
$tela = $form->editar($cp,'');
$cpf = $dd[2];

$cpf = ereg_replace('[^0-9]', '', $cpf);
$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

if($pre->validaCPF($cpf))
{
	
	//$pre->cadastrar_cpf($cpf);
	if ($form->saved > 0)
		{
			//echo '<br>=========='.$acp->acp_nome;
			//echo '<br>=========='.$acp->acp_nasc;
			//echo '<br>=========='.$acp->acp_mae;
			redirecina('pre_cad_01.php');
		} else {
			echo $tela;
		}
}else{
	echo $tela;
	if (strlen($acao) > 0) { echo '<h1>CPF inválido!</h1>'; }
}	

echo '
<script>
	jQuery(function($){
   		$("#dd2").mask("999.999.999-99");
	});
</script>
';	
?>

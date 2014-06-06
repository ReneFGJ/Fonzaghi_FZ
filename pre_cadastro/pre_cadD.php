<?php
require('cab.php');
require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
require('../_class/_class_acp.php');
$acp = new acp;
require('../_include/_class_form.php');
$form = new form;
$form->required_message = 0;
$form->required_message_post = 0;
$form->class_string = 'precad_form_string';
$form->class_string = 'precad_form_string';
$form->class_button_submit = 'precad_form_submit';
$form->class_form_standard = 'precad_form';
$form->class_memo = 'precad_form';
echo $hd->cab_banner($pre->gerar_tabela_tela_inicial());
echo '<center><div id="corpo">';
$cpf = '03367922986';
$acp -> consulta($cpf, 0, '');
$acp -> mostra_consulta($cpf);
$acp -> carregar_dados_SPC_125_DEBITO();
$acp -> carregar_dados_CHQ_242_CCF_BACEN();
echo $acp->tela;
echo '</div>';
	
?>

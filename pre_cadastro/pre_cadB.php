<?php
require('cab.php');
require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
require('../_class/_class_acp.php');
require('../_include/_class_form.php');
$form = new form;
$form->required_message = 0;
$form->required_message_post = 0;
$form->class_string = 'precad_form_string';
$form->class_string = 'precad_form_string';
$form->class_button_submit = 'precad_form_submit';
$form->class_form_standard = 'precad_form';
$form->class_memo = 'precad_form';
$id = $dd[0];
echo $hd->cab_banner($pre->gerar_tabela_tela_inicial());
echo '<center><div id="corpo">';
echo $pre->listar_contatos();
echo '<div id="corpo_cont">';
if(strlen(trim($id))>0){
	echo $pre->mostrar_contato($id);
}	
echo '</div>';
echo '</div>';
	
?>

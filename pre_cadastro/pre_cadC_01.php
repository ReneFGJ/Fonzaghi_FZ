<?php
require('cab.php');
require("../_class/_class_cadastro_pre_analise.php");
$pre = new cadastro_pre_analise;
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
$codigo = $dd[0];
$pre -> obter_dados($codigo,'00');
echo '<div align="left">';
//print_r($pre);
echo '</div>';
$pre ->calcular_pontuacao();
echo '<br>Pontuacao';
echo '<br>('.$pre ->TTpontos;
echo ')</div>';
echo $pre->mostrar_relatorio();
	
?>

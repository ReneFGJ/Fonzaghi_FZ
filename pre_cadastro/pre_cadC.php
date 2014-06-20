<?php
require('cab.php');
require("../_class/_class_cadastro_pre_consultora.php");
$cons = new cadastro_pre_consultora;
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

echo $hd->cab_banner($cons->gerar_tabela_tela_inicial());
echo '<center><div id="corpo">';
echo '<H1>Busca consultora</h1>';
if (strlen($dd[1]) == 0)
	{
		echo $cons->form_busca();
	} else {
		/* Mostra resultados */
		require ("../../_db/db_mysql_10.1.1.220.php");
		echo $cons->resultado_mostra('pre_cadC_01.php');
	}

echo '<BR><div style="height: 800px;">';
echo '</div>';
?>

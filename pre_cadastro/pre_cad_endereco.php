<?php
require('cab.php');

require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
require($include.'_class_form.php');
$form = new form;
$form->required_message = 0;
$form->required_message_post = 0;
$form->class_string = 'precad_form_string';
$form->class_button_submit = 'precad_form_submit';
$form->class_form_standard = 'precad_form';
$form->class_memo = 'precad_form';

$cp = $pre->cp_endereco();
$tela = $form->editar($cp,'');

if ($form->saved > 0)
	{
		echo $hd->retornar_para_pagina_principal();
	}else{
		echo $tela;
	}
	


echo '<script>
				$("#div3_new").toggleClass("textmenu");
				
				$( "#cl3" ).addClass( "circle3a" );
				
				$("#cad03").animate({
				width:"100%"
			  },400);
	</script>';
?>

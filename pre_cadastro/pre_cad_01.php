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
$_SESSION['angulo'] = 0;

echo $_SESSION['pre_aba_aberta'];
echo '<table width="100%">
		<tr class="corpo"  valign="top">
			<td width="30%">';
			require("pre_cad_menu.php");
echo '<td class="corpo" width="70%" align="right">';
echo $pre->gerar_abas_auxiliares('PRINCIPAL','../pre_cadastro/pre_cad_01.php',1,1);
echo '<div id="cad01" style="width:1px" >';
/* Dados CP01 */
$cp = $pre->cp_01();
$tela = $form->editar($cp,'');
if ($form->saved > 0)
	{
		$pg = '02';
		if (strlen($dd[92]) > 0) 
		{
			 $pg = strzero($dd[92],2); 
		}
		redirecina('pre_cad_'.$pg.'.php');
	} else {
		$pg = '02';
		if (strlen($dd[92]) > 0) 
		{
			 $pg = strzero($dd[92],2); 
			 redirecina('pre_cad_'.$pg.'.php'); 
		}
		echo $tela;
	}
echo '</div>';
echo '</td></tr></table>';

echo '<script>
		$("#div1_new").toggleClass("textmenu");
		
		jQuery(function($){
	   		$("#dd4").mask("9.999.999-9");
		});	
		$( "#cl1" ).addClass( "circle1a" );
		$("#cad01").animate({ width:"50%" },400);
</script>
';	

	
?>

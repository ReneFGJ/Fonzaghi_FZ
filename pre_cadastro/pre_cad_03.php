<?php
require('cab.php');

require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
require('../../include/_class_form.php');
$form = new form;
$form->required_message = 0;
$form->required_message_post = 0;
$form->class_string = 'precad_form_string';
$form->class_button_submit = 'precad_form_submit';
$form->class_form_standard = 'precad_form';
$form->class_memo = 'precad_form';

$_SESSION['angulo'] = 40;
echo $hd->cab_banner($pre->gerar_tabela_tela_inicial());
echo '<table width="100%">
		<tr class="corpo"  valign="top">
			<td width="30%">';
			require("pre_cad_menu.php");
echo '<td class="corpo" width="70%">';
echo '<div id="cad03" style="width:0px" >';

/* Dados CP03 */
$cp = $pre->cp_03();
$tela = $form->editar($cp,'');
if ($form->saved > 0)
	{
		$pg = 'resumo';
		redirecina('pre_cad_'.$pg.'.php');
	} else {
		echo $tela;
	}

echo '</div>';
echo '</td></tr></table>';
echo '<script>
				$("#div3_new").toggleClass("textmenu");
				
				$( "#cl3" ).addClass( "circle3a" );
				
				$("#cad03").animate({
				width:"100%"
			  },600);
	</script>';
$pre->bloquear_campos('dd0',$dd[0]);	
?>

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

$_SESSION['angulo'] = 20;
echo $hd->cab_banner($pre->gerar_tabela_tela_inicial());

echo '<table width="100%">
		<tr class="corpo"  valign="top">
			<td width="30%">';
			require("pre_cad_menu.php");
echo '<td class="corpo" width="70%">';
echo '<div id="cad02" style="width:0px" >';
/* Dados CP02 */
$cp = $pre->cp_02();
$tela = $form->editar($cp,'');

if ($form->saved > 0)
	{
		$pg = '03';
		if (strlen($dd[92]) > 0) { $pg = strzero($dd[92],2); }
		redirecina('pre_cad_'.$pg.'.php');
	} else {
		if (strlen($dd[92]) > 0) { $pg = strzero($dd[92],2); redirecina('pre_cad_'.$pg.'.php'); }
		echo $tela;
	}

echo '</td></tr></table>';
echo '<script>
	$("#div2_new").toggleClass("textmenu");
	
	$( "#cl2" ).addClass( "circle2a" );
	$("#cad02").animate({
				width:"100%"
			  },600);
</script>
';		
		
?>

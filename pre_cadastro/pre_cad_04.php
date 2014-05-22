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
$_SESSION['angulo'] = 60;

echo '<table width="100%">
		<tr class="corpo"  valign="top">
			<td width="30%">';
			require("pre_cad_menu.php");
echo '<td class="corpo" width="70%" align="right">';
echo '<div id="cad04" style="width:1px" >';

/* Dados CP04 */
$cp = $pre->cp_04();
$tela = $form->editar($cp,'');

if ($form->saved > 0)
	{
		$pg = '05';
		if (strlen($dd[92]) > 0) { $pg = strzero($dd[92],2); }
		redirecina('pre_cad_'.$pg.'.php');		
	} else {
		if (strlen($dd[92]) > 0) { $pg = strzero($dd[92],2); redirecina('pre_cad_'.$pg.'.php'); }
		echo $tela;
	}

echo '</td></tr></table>';
echo '<script>
				$("#div4_new").toggleClass("textmenu");
		
				$( "#cl4" ).addClass( "circle4a" );
				
				$("#cad04").animate({
				width:"100%"
			  },400);
	</script>';
?>

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
		<tr valign="top">
			<td width="50%">';
			require("pre_cad_menu.php");
echo '<td width="50%">';

/* Dados CP04 */
$cp = $pre->cp_04();
$tela = $form->editar($cp,'');

if ($form->saved > 0)
	{
		redirecina('pre_cad_05.php');
	} else {
		echo $tela;
	}

echo '</td></tr></table>';
echo '<script>
				$("#div4_new").toggleClass("textmenu");
	</script>';
?>

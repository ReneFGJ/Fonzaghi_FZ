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

/*lastupdate/lastlog*/
$dd[11] = $user->user_log;
$dd[12] = date('Ymd');

$_SESSION['angulo'] = 0;
echo $hd->cab_banner($pre->gerar_tabela_tela_inicial());
echo $_SESSION['pre_aba_aberta'];

echo '<table width="100%">
		<tr class="corpo"  valign="top">
			<td width="30%">';
			require("pre_cad_menu.php");
echo '<td class="corpo" width="70%">';
echo '<div id="cad01" style="width:0px">';
/* Dados CP01 */
$cp = $pre->cp_01();
require ("../../_db/db_mysql_10.1.1.220.php");
$dd[0] = $_SESSION['PG1_DD0'];
$tela = $form->editar($cp,$pre->tabela);
if ($form->saved > 0)
	{
		$pg = '02';
		redirecina('pre_cad_'.$pg.'.php');
	} else {
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
		$("#cad01").animate({ left:"50%",width:"100%" },600);
</script>
';
$pre->bloquear_campos('dd0',$dd[0]);
//$pre->bloquear_campos('dd1',$dd[1]);

	
?>
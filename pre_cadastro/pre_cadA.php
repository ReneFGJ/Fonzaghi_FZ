<?php
require ('cab.php');
require ("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
require ('../_class/_class_acp.php');
require ('../_include/_class_form.php');
$form = new form;
$form -> required_message = 0;
$form -> required_message_post = 0;
$form -> class_string = 'precad_form_string';
$form -> class_string = 'precad_form_string';
$form -> class_button_submit = 'precad_form_submit';
$form -> class_form_standard = 'precad_form';
$form -> class_memo = 'precad_form';
$cp = $pre -> cp_00();
$tela = $form -> editar($cp, '');
$cpf = $dd[2];
$cpf = ereg_replace('[^0-9]', '', $cpf);
$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
echo $hd -> cab_banner($pre -> gerar_tabela_tela_inicial());
echo '<center><div id="corpo">';
$id_cont = $dd[70];

if (strlen(trim($id_cont)) == 0) {
	$tx = $pre -> listar_contatos();
	$tx1 = $tela;
} else {
	$tx = $pre -> mostrar_contato($id_cont);
	$tx .='<div class="bt_acoes_box">'.$pre -> gerar_painel_de_acoes($id_cont,'WILLIAN').'</div>';
	$tx1 = $tela;
}
if ($pre -> validaCPF($cpf)) {
	$pre -> cadastrar_cpf($cpf);
	if ($form -> saved > 0) {
		$_SESSION['ID_PG1'] = $pre -> id;
		$_SESSION['nome'] = $pre -> nome;
		redirecina('pre_cad_01.php?dd0=' . $pre -> id);
	} else {
		echo '<table>	
				<tr><td>
					<div class="pre_painel">
						<img width="300px" src="../img/imgboxinfo.png">
						<div class="box_cont"></div>
					</div>
				</td><td width="20px"></td>
				<td>';

		echo '	<div class="pre_painel">
						<img width="300px" src="../img/imgboxcont.png">
						<div  class="box_cont">' . $tx . '</div>
					</div>
				</td><td width="20px"></td>';

		echo '<td>
					<div class="pre_painel">
						<img width="300px" src="../img/imgboxcad.png">
						<div  class="box_cont">' . $tela . $msgx . '</div>
					</div>
				</td></tr></table>
			';

	}
} else {
	if (strlen($acao) > 0) { $msgx = '<div class="msg_errorimage"></div><div class="msg_errortext"> CPF INVÁLIDO! </div>';
	}
	echo '<table>	
				<tr><td>
					<div align="center" width="30%" style="position:relative; float:left">
						<img class="box_img" src="../img/imgboxinfo.png">
						<div class="box_cont"></div>
					</div>
				</td><td width="20px"></td>';

	echo '		<td>
					<div align="center" width="30%" style="position:relative; float:left">
						<img class="box_img" src="../img/imgboxcont.png">
						<div class="box_cont">' . $tx . '</div>
					</div>
				</td><td width="20px"></td>';

	echo '		<td>
					<div  align="center" width="30%" style="position:relative; float:left">
						<img class="box_img" src="../img/imgboxcad.png">
						<div class="box_cont">' . $tx1 . $msgx . '</div>
					</div>
				</td></tr></table>
			';
}
echo '</div>';
echo '<div id="pre_acao"></div>';
echo $pre -> gerar_js();
echo '
<script>
	jQuery(function($){
   		$("#dd2").mask("999.999.999-99");
	});
</script>
';

echo $pre -> autocomplete('dd4');
?>

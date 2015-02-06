<?php
require ("cab.php");
//require ($include . 'sisdoc_debug.php');
require ($include . 'sisdoc_data.php');
require ('../js/sisdoc_windows.php');
require ('../_class/_class_form.php');
require ("../_class/_class_cadastro_pre_analise.php");
$pre = new cadastro_pre_analise;
$_SESSION['PG1_DD0'] = '';

/* Classe de comentarios */
require("../_class/_class_cadastro_pre_comment.php");
$cm = new cad_comment;

require ("../_class/_class_acp.php");
$acp = new acp;
$pre -> le($dd[0]);
$pre -> obter_dados($dd[0], '00');
$pre -> calcular_pontuacao();

$bt_menu = $pre->regras_de_acesso($dd[0],$pre -> status);
$onclickR = '<span width="200px" class="cursor bt_botao bt_green_dark" onclick="mostra_dados_pre_cad(\''.$dd[0].'\',\'RESUMO\' );" >';
$onclickP = '<span width="200px" class="cursor bt_botao bt_green_dark" onclick="mostra_dados_pre_cad(\''.$dd[0].'\',\'PONTUACAO\' );" >';

$tela = '<table  class="cab_status" width="100%"><tr >
			<td class="noprint" colspan="2" align="left" width="30%">
				<nav>
					'.$onclickR.'RESUMO</span>
					'.$onclickP.'PONTUACAO</span>
				</nav>
			</td>
			<td class="noprint" colspan="2" align="right" width="70%">
			<div id="acoes_status">'.$bt_menu.'</div>
			</td>
		</tr>
		
		<tr>
			<td width="10%">
				<div class="cab_statusB" align="center">Restrições (' . $pre -> TTrestricoes . ')</div>
			</td>
			<td width="10%">
				<div class="cab_statusB" align="center">Valor (' . number_format($pre -> TTrestricoes_vlr,2) . ')</div>
			</td>
			<td width="10%">
				<div class="cab_statusA" align="center">' . $pre -> status($pre -> status) . '</div>
			</td>
			<td width="10%">
				<div class="cab_statusB" align="center">PONTUAÇÃO (' . $pre -> TTpontos . ')</div>
			</td>
			
		</tr>
		</table>
			<div id="mostra_dados_pre_cad"></div>
			<script> 
					$( document ).ready(function() {
						mostra_dados_pre_cad(\''.$dd[0].'\',\'RESUMO\' );
					});
			</script>
			';
echo '<div class="print_resumo">';
	echo $tela;
	
	echo '<BR><BR>';
	/* GED - Arquivos de Documentos */
	require("../../_db/db_mysql_pre_cad.php");
	require("_ged_config.php");
	
	$ged->protocol = $pre->cliente;
	echo $ged->filelist();
	echo $ged->upload_botton_with_type($ged->protocol);
	
	/* Comentarios */
	$cm->codigo = $pre->cliente;
	$cm->protocolo = $pre->cliente;
	$cm->user_login = $_SESSION['nw_user'];
	
	require("../../_db/db_mysql_pre_cad.php");
	
	echo $cm->comment_display();

echo '</div>';

echo '<BR>.<BR>.';


?>

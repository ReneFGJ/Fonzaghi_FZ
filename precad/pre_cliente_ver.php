<?php
require ("cab.php");

require ($include . 'sisdoc_data.php');
require ('../_class/_class_form.php');
require ("../_class/_class_cadastro_pre_analise.php");
$pre = new cadastro_pre_analise;
require ("../_class/_class_acp.php");
$acp = new acp;
$pre -> le($dd[0]);
$pre -> obter_dados($dd[0], '00');
$pre -> calcular_pontuacao();


$bt_menu = $pre->regras_de_acesso($dd[0],$pre -> status);
$onclickR = '<span width="200px" class="cursor bt_botao" onclick="mostra_dados_pre_cad(\''.$dd[0].'\',\'RESUMO\' );" >';
$onclickP = '<span width="200px" class="cursor bt_botao" onclick="mostra_dados_pre_cad(\''.$dd[0].'\',\'PONTUACAO\' );" >';

$tela = '<table  class="cab_status" width="100%"><tr>
			<td colspan="2" align="left" width="30%">
				<nav>
					'.$onclickR.'RESUMO</span>
					'.$onclickP.'PONTUACAO</span>
				</nav>
			</td>
			<td colspan="2" align="right" width="70%">
			<div id="acoes_status">'.$bt_menu.'</div>
			</td>
		</tr>
		<tr>
			<td colspan="4"><div id="progress_bar"></div></td>
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

echo $tela;
?>

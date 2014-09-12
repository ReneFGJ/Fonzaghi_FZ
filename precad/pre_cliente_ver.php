<?php
require ("cab.php");

require ($include . 'sisdoc_data.php');
require ($include . '_class_form.php');
require ("../_class/_class_cadastro_pre_analise.php");
$pre = new cadastro_pre_analise;
require ("../_class/_class_acp.php");
$acp = new acp;
$pre -> le($dd[0]);
$pre -> obter_dados($dd[0], '00');
$pre -> calcular_pontuacao();





$onclickR = '<a class="cursor bt_resumo" onclick="mostra_dados_pre_cad(\''.$dd[0].'\',\'RESUMO\' );" >';
$onclickP = '<a class="cursor bt_pontuacao" onclick="mostra_dados_pre_cad(\''.$dd[0].'\',\'PONTUACAO\' );" >';
$tela = '<table  class="cab_status" width="100%"><tr>
			<td>
				'.$onclickR.'RESUMO</a>				
				'.$onclickP.'PONTUACAO</a>
			</td>
			<td>
				<div class="cab_statusA" align="right">' . $pre -> status($pre -> status) . '</div>
				<div class="cab_statusB" align="right">PONTUAÇÃO (' . $pre -> TTpontos . ')</div>
			</td>	
		</tr></table>
			<div id="mostra_dados_pre_cad"></div>';

echo $tela;
?>

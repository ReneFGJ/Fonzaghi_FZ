<?php
require("cab.php");

require($include.'sisdoc_data.php');
require($include.'_class_form.php');
require("../_class/_class_cadastro_pre_analise.php");
$pre = new cadastro_pre_analise;
require("../_class/_class_acp.php");
$acp = new acp;
echo '<div></div>';
$pre->le($dd[0]);
$pre->obter_dados($dd[0],'00');
$pre->calcular_pontuacao();

$telax  = $pre->mostra();
$telax .= '<h3>Contatos Pessoal</h3>';
$telax .= $pre->lista_telefone(0);
$telax .= '<h3>Endereço</h3>';
$telax .= $pre->lista_endereco(0);
$telax .= '<h3>Referências</h3>';
$telax .= $pre->lista_referencia(0);
$telax .= $pre->mostrar_relatorio();
$sty = ' style="background:#000000;
				   font-size:20px;
				   text-align:center;
				   color:#FFFFFF;
				   font-family:RobotoThin;
				   font-weight:900;" ';
$sty1 = 'style=" font-size:30px;" ';
				   
$pontuacao = '<div width="100%" '.$sty.'>
				<div align="right">'.$pre->status($pre->status).'</div>
				<div align="right" '.$sty1.'>PONTUAÇÃO ('.$pre->TTpontos.')</div>
			</div>';
$tela = $pontuacao.$telax;

echo $tela;
?>

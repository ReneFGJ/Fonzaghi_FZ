<?php
$include = '../';
$include_db = '../../';
require ('../db.php');
require("../_class/_class_cadastro_pre_analise.php");
$pre = new cadastro_pre_analise;
require("../_class/_class_acp.php");
$acp = new acp;


$aux = uppercase($dd[0]);
$verb = uppercase($dd[1]);

switch($verb) {
	case 'APROVADO' :
		$pre->salvar_status($aux,'A');
		echo '<script>location.reload();</script>';
		break;
	case 'RECUSADO' :
		$pre->salvar_status($aux,'R');
		echo '<script>location.reload();</script>';
		break;
	case 'EDICAO' :
		$pre->salvar_status($aux,'@');
		echo '<script>location.reload();</script>';
		break;
		
	case 'LISTA_D' :
		echo $pre->lista_status_dia($aux);
		break;
	case 'LISTA_W' :
		echo $pre->lista_status_semana($aux);
		break;		
	case 'LISTA_M' :
		echo $pre->lista_status_mes($aux);
		break;	
	case 'RESUMO' :
		echo tela_1();
		break;
	case 'PONTUACAO' :
		echo $pre->lista_status_mes($aux);
		break;		
	default :
		break;
}


function tela_1(){
	$pre->le($dd[0]);
	$pre->obter_dados($dd[0],'00');
	$pre->calcular_pontuacao();
	
	$telax  = $pre->mostra();
	$telax .= '<h3>Contatos Pessoal</h3>';
	$telax .= $pre->lista_telefone(0);
	$telax .= '<h3>Endere�o</h3>';
	$telax .= $pre->lista_endereco(0);
	$telax .= '<h3>Refer�ncias</h3>';
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
					<div align="right" '.$sty1.'>PONTUA��O ('.$pre->TTpontos.')</div>
				</div>';
	$tela = $pontuacao.$telax;
	$sx = $tela;
	return($sx);
}







?>
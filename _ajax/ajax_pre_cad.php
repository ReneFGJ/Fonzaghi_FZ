<?php
$include = '../';
$include_db = '../../';
require ('../db.php');
require ($include . 'sisdoc_data.php');
require ($include . '_class_form.php');
require ("../_class/_class_cadastro_pre_analise.php");
$pre = new cadastro_pre_analise;

require ("../_class/_class_cadastro_pre_mailing.php");
$mail = new cadastro_pre_mailing;
$mail -> include_class = $include_db;

require ("../_class/_class_acp.php");
$acp = new acp;

$aux = uppercase($dd[0]);
$verb = uppercase($dd[1]);

switch($verb) {
	case 'APROVADO' :
		$pre -> salvar_status($aux, 'A');
		echo '<script>location.reload();</script>';
		break;
	case 'RECUSADO' :
		$pre -> salvar_status($aux, 'R');
		echo '<script>location.reload();</script>';
		break;
	case 'EDICAO' :
		$pre -> salvar_status($aux, '@');
		echo '<script>location.reload();</script>';
		break;
	case 'LISTA_D' :
		echo $pre -> lista_status_dia($aux);
		break;
	case 'LISTA_W' :
		echo $pre -> lista_status_semana($aux);
		break;
	case 'LISTA_M' :
		echo $pre -> lista_status_mes($aux);
		break;
	case 'RESUMO' :
		$pre -> le($dd[0]);
		$pre -> obter_dados($dd[0], '00');
		$pre -> calcular_pontuacao();
		echo $pre -> mostra_resumo();
		break;
	case 'PONTUACAO' :
		$pre -> le($dd[0]);
		$pre -> obter_dados($dd[0], '00');
		$pre -> calcular_pontuacao();
		echo $pre -> mostrar_relatorio();
		break;
	case 'MAILING_REMOVE' :
		require ($include_db . 'db_cadastro.php');
		echo $mail -> mailing_remove($aux);
		break;
	case 'MAILING_RETORNO' :
		require ($include_db . 'db_cadastro.php');
		/*Verifica se existe cliente na base postgres e se o CPF é valido*/
		if($mail -> mailing_retorno_busca_cliente($aux)){
				/*Verifica se o CPF já existe na base nova */
				require ($include_db . "db_mysql_" . $ip . ".php");
				if (!($mail -> recupera_codigo_pelo_cpf($mail -> cpf))) {
					/*Consulta acp*/
					require ($include_db . 'db_informsystem.php');
					if ($mail -> mailing_retorno_consulta_acp()) {
						require ($include_db . "db_mysql_" . $ip . ".php");
						/*insere CPF*/
						echo $mail -> mailing_retorno_inserir_cpf($mail -> cpf);
						$mail -> inserir_complemento();
					} else {
						echo '<div class="green_light fnt_black">JA CONSTA ESTE CPF EM NOSSO CADASTRO!!!</div>';
					}
				} else {
					echo '<div class="green_light fnt_black">JA CONSTA ESTE CPF EM NOSSO CADASTRO!!!</div>';
				}
		}else{
			echo '<div class="green_light fnt_black">CPF INVALIDO!!!</div>';
		}	

		break;
	default :
		break;
}

function tela_1() {
	$pre -> le($dd[0]);
	$pre -> obter_dados($dd[0], '00');
	$pre -> calcular_pontuacao();

	$telax = $pre -> mostra();
	$telax .= '<h3>Contatos Pessoal</h3>';
	$telax .= $pre -> lista_telefone(0);
	$telax .= '<h3>Endereço</h3>';
	$telax .= $pre -> lista_endereco(0);
	$telax .= '<h3>Referências</h3>';
	$telax .= $pre -> lista_referencia(0);
	$telax .= $pre -> mostrar_relatorio();
	$sty = ' style="background:#000000;
					   font-size:20px;
					   text-align:center;
					   color:#FFFFFF;
					   font-family:RobotoThin;
					   font-weight:900;" ';
	$sty1 = 'style=" font-size:30px;" ';

	$pontuacao = '<div width="100%" ' . $sty . '>
					<div align="right">' . $pre -> status($pre -> status) . '</div>
					<div align="right" ' . $sty1 . '>PONTUAÇÃO (' . $pre -> TTpontos . ')</div>
				</div>';
	$tela = $pontuacao . $telax;
	$sx = $tela;
	return ($sx);
}
?>
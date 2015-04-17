<?php
$include = '../';
$include_db = '../../';
require ('../db.php');
require('../progress.php');
require ($include . 'sisdoc_data.php');
require ($include . '_class_form.php');
require ("../_class/_class_cadastro_pre_analise.php");
$pre = new cadastro_pre_analise;

require("../_class/_class_cadastro_pre_importacao.php");
$imp = new cadastro_pre_importacao;

//require ("../_class/_class_messages.php");
//$msg = new message;

require ("../_class/_class_cadastro_pre_mailing.php");
$mail = new cadastro_pre_mailing;
$mail -> include_class = $include_db;

require ("../_class/_class_acp.php");
$acp = new acp;

$aux = uppercase($dd[0]);
$verb = uppercase($dd[1]);
$aux2 = uppercase($dd[2]);

switch($verb) {
	case 'LISTA_D' :
		echo $pre -> lista_status_dia($aux);
		break;
	case 'LISTA_W' :
		echo $pre -> lista_status_semana($aux);
		break;
	case 'LISTA_M' :
		echo $pre -> lista_status_mes($aux);
		break;
	case 'LISTA_AGENDA' :
		require ("../../_db/db_206_telemarket.php");
		switch ($aux) {
			case 'D':
				echo $pre -> lista_agenda_dia();		
				break;
			case 'W':
				echo $pre -> lista_agenda_semana();		
				break;
			case 'M':
				echo $pre -> lista_agenda_mes();		
				break;
			default:
			break;
		}
		
		break;	
	case 'RESUMO' :
		$pre -> le($dd[0]);
		$pre -> obter_dados($dd[0], '00');
		$pre -> calcular_pontuacao();
		
		echo $pre -> mostra_resumo();
		echo $pre->restricoesACP();
		echo $pre->informantesACP();
		echo $pre->complementarACP();
		
		
		echo '<br><br><br>';
		break;
	case 'PONTUACAO' :
		$pre -> le($dd[0]);
		$pre -> obter_dados($dd[0], '00');
		$pre -> calcular_pontuacao();
		echo $pre -> mostrar_relatorio();
		break;
	case 'MAILING_REMOVE' :
		$cliente = $aux;
		$login = $_SESSION['nw_user'];
		$acao = "225 - REMOVEU MAILING";
		$acao_cod = '225';
		$status_registro = 'I';
		$pre ->inserir_log($cliente, $login, $acao, $acao_cod, $status_registro);
		require ($include_db . 'db_cadastro.php');
		echo $mail -> mailing_remove($cliente);
		redirecionar("pre_mailing.php",3);
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
						/*redireciona com delay de 5 segundos*/
						redirecionar("pre_cliente_ver.php?dd0=".$aux,5);
					} else {
						echo '<div class="green_light fnt_black">JA CONSTA ESTE CPF EM NOSSO CADASTRO!!!</div>';
						/*redireciona com delay de 5 segundos*/
						redirecionar("pre_mailing.php",5);
					}
				} else {
					echo '<div class="green_light fnt_black">JA CONSTA ESTE CPF EM NOSSO CADASTRO!!!</div>';
					/*redireciona com delay de 5 segundos*/
					redirecionar("pre_mailing.php",5);
				}
		}else{
			echo '<div class="green_light fnt_black">CPF INVALIDO!!!</div>';
			/*redireciona com delay de 5 segundos*/
			redirecionar("pre_mailing.php",5);
		}	
		break;
	case 'CEP_BUSCA' :
		global $dd;
		require ("../_class/_class_geocode.php");
		echo $pre->buscar_por_cep($aux);
		break;	
	case 'ALTERAR_STATUS' :
		if($aux2<>'A'){
			require ($include_db."db_mysql_" . $ip . ".php");
			$pre->salvar_status($aux,$aux2);
			/*redireciona com delay de 5 segundos*/
			redirecionar("pre_cliente_ver.php?dd0=".$aux,2);
		}else{
			require ($include_db."db_mysql_" . $ip . ".php");
			$cliente = $dd[0];
			$pre -> le($cliente);
			require($include_db.'db_cadastro.php');
			$vld = $imp->gera_query_insert($pre); 
			switch ($vld) {
				case 0:
						echo '<script>alert("Erro : '.$imp->error.'")</script>';
						redirecionar("pre_cliente_ver.php?dd0=".$aux,2);	
					break;
				case 1:
					require ($include_db."db_mysql_" . $ip . ".php");
					
					$login = $_SESSION['nw_user'];
					$status = 'A';
					$acao = "900 - ATUALIZOU CADASTRO POSTGRES";
					$acao_cod = '900';
					$pre->inserir_log($cliente, $login, $acao, $acao_cod,$status);
					
					$pre->salvar_status($aux,$aux2);
					/*redireciona com delay de 5 segundos*/
					redirecionar("pre_cliente_ver.php?dd0=".$aux,2);	
					break; 
				case 2:
					require ($include_db."db_mysql_" . $ip . ".php");
					$login = $_SESSION['nw_user'];
					$status = 'A';
					$acao = "905 - INSERIU CADASTRO POSTGRES";
					$acao_cod = '905';
					$pre->inserir_log($cliente, $login, $acao, $acao_cod,$status);
					
					$pre->salvar_status($aux,$aux2);
					/*redireciona com delay de 5 segundos*/
					
					redirecionar("pre_cliente_ver.php?dd0=".$aux,2);
					break;
			}	
		}
		
		
		break;	
	case 'MSG' :
		//require($include.'_class_form.php');
		//$form = new form;
		//echo $form->ajax('msg','');
		echo 'aqui';
		break;	
	default :
		break;
}

function redirecionar($link,$delay){
	sleep($delay);
	echo '<script>window.location.replace("'.$link.'");</script>';
}

function tela_1() {
	global $editar;
	
	$editar =0;
	$pre -> le($dd[0]);
	$pre -> obter_dados($dd[0], '00');
	$pre -> calcular_pontuacao();

	$telax = $pre -> mostra();
	$telax .= '<h3>Contatos Pessoal</h3>';
	$telax .= $pre -> lista_telefone();
	$telax .= '<h3>Endereço</h3>';
	$telax .= $pre -> lista_endereco();
	$telax .= '<h3>Referências</h3>';
	$telax .= $pre -> lista_referencia();
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
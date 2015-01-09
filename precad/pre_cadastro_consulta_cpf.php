<?php
require("cab.php");
require("../_class/_class_acp.php");
require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');

$include_db = '../../_db/';
if (strlen($dd[1]) > 0)
	{
		$cpf = $dd[1];
		
		$pre -> recupera_codigo_pelo_cpf($cpf);
		$pre -> recuperar_codigo_complemento();
		if (round($pre -> cliente) == 0) {
			require($include_db."db_informsystem.php");
			$acp = new acp;
			$acp -> consulta($cpf, 0, '');
			$acp -> mostra_consulta($cpf);
			echo $acp->tela;
			$filename = $include_db."db_mysql_".$ip.".php";
			require($filename);
			$pre -> nome = $acp -> acp_nome;
			$pre -> nasc = $acp -> acp_nasc;
			$pre -> mae = $acp -> acp_mae;
				if(strlen(trim($pre -> nome))>0){
					//Verifica se já há cliente na tabela cadastro, caso haja recupera o codigo
					require($include_db."db_cadastro.php");
					$pre -> verifica_se_existe_cliente($cpf);
					require($include_db."db_mysql_".$ip.".php");			
					$pre -> inserir_cpf($cpf);	
					echo '<HR>9<HR>';
					$pre -> inserir_complemento();
					echo '<HR>10<HR>';
					redirecina('pre_cadastro.php?dd1=&dd2='.$cpf.'&acao=buscar');
					echo '<HR>11<HR>';
				}else{
					echo '<H1>Não cadastrado, falha na consulta da ACP!!!</H1>';
				}
		}						
	}
?>

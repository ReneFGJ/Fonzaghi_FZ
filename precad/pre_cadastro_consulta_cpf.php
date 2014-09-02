<?php
require("cab.php");
require("../_class/_class_acp.php");
require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

require($include.'sisdoc_data.php');

if (strlen($dd[1]) > 0)
	{
		$cpf = $dd[1];
		
		echo '<HR>1<HR>';
		$pre -> recupera_codigo_pelo_cpf($cpf);
		echo '<HR>2<HR>';
		$pre -> recuperar_codigo_complemento();
		if (round($pre -> cliente) == 0) {
			echo '<HR>3<HR>';
			require("../../_db/db_informsystem.php");
			echo '<HR>4<HR>';
			$acp = new acp;
			$acp -> consulta($cpf, 0, '');
			echo '<HR>5<HR>';
			$acp -> mostra_consulta($cpf);
			echo $acp->tela;
			$filename = $include_db."db_mysql_".$ip.".php";
			require($filename);
			$pre -> nome = $acp -> acp_nome;
			$pre -> nasc = $acp -> acp_nasc;
			$pre -> mae = $acp -> acp_mae;
			$pre -> inserir_cpf($cpf);
			$pre -> inserir_complemento();
			redirecina('pre_cadastro.php?dd1=&dd2='.$cpf.'&acao=buscar');
		}						
	}
?>

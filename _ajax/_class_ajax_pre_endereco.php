<?php
require("../_class/_class_cadastro_pre.php");

class ajax
	{
		var $tabela = '';
		function __construct()
			{
		//		$cad = new cadastro_pre;
		//		$this->tabela = $cad->tabela_telefone;
			}
		function cp()
			{
				global $dd,$acao;
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$cp = $cad->cp_endereco();
				return($cp);
			}	
		function insere_registro($dd)
			{
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$cep = $dd[4];
				$rua = $dd[5];
				$numero = $dd[6];
				$complemento = $dd[7];
				$bairro = $dd[8];
				$cidade = $dd[9];
				$estado = 'PR';
				$cad->insere_endereco($rua,$numero,$complemento,$cep,$bairro,$cidade,$estado);				
			}
		function refresh()
			{
				global $dd;
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$sx = $cad->lista_endereco_mostra($dd[1],1);
				return($sx);
			}
	}
?>
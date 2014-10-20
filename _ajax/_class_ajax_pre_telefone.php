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
				$cp = $cad->cp_telefone();
				return($cp);
			}	
		function insere_registro($dd)
			{
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$ddd = $dd[3];
				$telefone = $dd[4];
				$tipo = $dd[5];
				$cad->insere_telefone($ddd,$telefone,$tipo);
			}
		function refresh()
			{
				global $dd;
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$sx = $cad->lista_telefone_mostra($dd[1],1);
				return($sx);
			}
	}
?>
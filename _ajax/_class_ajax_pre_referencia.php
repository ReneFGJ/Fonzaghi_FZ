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
				$cp = $cad->cp_referencia();
				return($cp);
			}	
		function insere_registro($dd)
			{
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$nome = strtoupper($dd[3]);
				$grau = $dd[4];
				$ddd = $dd[5];
				$telefone = $dd[6];
				$obs = strtoupper($dd[7]);
				$cad->insere_referencia($nome,$ddd,$telefone,$obs,$data,$grau);			
			}
		function refresh()
			{
				global $dd,$editar;
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$sx = $cad->lista_referencia_mostra($dd[1],$editar);
				return($sx);
			}
	}
?>
<?php
require ("../_class/_class_vendas_funcionario.php");
require ("../../_db/db_fghi.php");
require ($include.'sisdoc_data.php');

class ajax {
	var $tabela = '';
	function __construct() {
		//		$cad = new cadastro_pre;
		//		$this->tabela = $cad->tabela_telefone;
	}

	function cp() {
		return ($cp);
	}

	function refresh() {
		global $dd;
		$cracha = $_SESSION['user_id'];
		$venda = new vendas_funcionario;
		echo $venda->lista_compras($cracha);
	}

}
?>

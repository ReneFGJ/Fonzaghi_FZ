<?php
require ("../_class/_class_user.php");
require ("../../_db/db_fghi.php");
class ajax {
	var $tabela = '';
	function __construct() {
		//		$cad = new cadastro_pre;
		//		$this->tabela = $cad->tabela_telefone;
		
		echo '
		
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script>
		$(document).ready(function(){
		  $("#dd5").focus(function(){
		    alert("aqui");
		  });
		});
		</script>
		';
	}

	function cp() {
		return ($cp);
	}

	function refresh() {
		global $dd;
		$cracha = $dd[1];
		
		$nw = new user;
		echo '<h3>Saldo para compras: R$ ';
		echo number_format($nw->saldo_compras_funcionario($cracha),2,',','.');
		echo '</h3>';
		
	}

}
?>

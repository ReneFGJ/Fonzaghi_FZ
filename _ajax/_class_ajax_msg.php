<?php
require("../_class/_class_messages.php");

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
				$msg=array();
				array_push($msg, "0-Recepção, utilizar para informações direcionadas a recepção");
				array_push($msg, "1-Informativa, e removido automaticamente após primeira leitura");
				array_push($msg, "2-Informativa, removida somente manualmente");
				array_push($msg, "3-Informativa, removida somente pelas coordenadoras ou supervisora");
				array_push($msg, "4-Informativa, removida somente pela supervisora");
				array_push($msg, "5-Informativa, removida somente pelo jurídico");
				array_push($msg, "6-Restritiva, removida pelas coordenadoras");
				array_push($msg, "7-Restritiva, removida pela supervisora");
				array_push($msg, "8-Restritiva, removida pelo jurídico, com possibilidade de liberar");
				array_push($msg, "9-Restritiva, Bloqueio total, removido pelo jurídico");
				
				$cp = array();
				array_push($cp,array('$T65:2','','Texto',True,True,''));
				array_push($cp,array('$O 0:'.$msg[0].'&1:'.$msg[1].'&2:'.$msg[2].'&3:'.$msg[3].'&4:'.$msg[4].'&5:'.$msg[5].'&6:'.$msg[6].'&7:'.$msg[7].'&8:'.$msg[8].'&9:'.$msg[9].'','','Tipo de mensagem',True,True,''));
				
				return($cp);
			}	
		function insere_registro($dd)
			{
				/*
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$ddd = $dd[3];
				$telefone = $dd[4];
				$tipo = $dd[5];
				$cad->insere_telefone($ddd,$telefone,$tipo);
				* 
				*/
			}
		function refresh()
			{
				global $dd;
				
				return($sx);
			}
	}
?>
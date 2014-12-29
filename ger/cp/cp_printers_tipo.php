<?
require("../db_206_printers.php");
$tabela = "printers_tipo";
$cp = array();
array_push($cp,array('$H8','id_pt','id_pt',False,True,''));
array_push($cp,array('$H7','pt_codigo','pt_codigo',False,True,''));
array_push($cp,array('$S30','pt_modelo','Modelo',False,True,''));
array_push($cp,array('$O 1:SIM&0:NУO','pt_ativo','Ativa',False,True,''));
array_push($cp,array('$T50:5','pt_observacao','Observaчуo',False,True,''));

/// Gerado pelo sistem "base.php" versao 1.0.5
?>
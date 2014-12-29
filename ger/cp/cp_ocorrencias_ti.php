<?
require("../db_fghi2.php");
$tabela = "ocorrencias_ti";
$cp = array();
array_push($cp,array('$H8','id_ot','id_ot',False,True,''));
array_push($cp,array('$H3','ot_codigo','ot_codigo',False,True,''));
array_push($cp,array('$S60','ot_nome','Nome',False,True,''));
array_push($cp,array('$S10','ot_log','Log',False,True,''));
array_push($cp,array('$O 1:SIM&0:NÃO','ot_ativo','Ativo',False,True,''));

/// Gerado pelo sistem "base.php" versao 1.0.5
?>
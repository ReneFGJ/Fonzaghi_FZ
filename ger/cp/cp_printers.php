<?
require("../db_206_printers.php");
require($include."sisdoc_data.php");
$tabela = "printers";
$cp = array();
array_push($cp,array('$H5','id_pr','',False,True,''));
array_push($cp,array('$H7','pr_codigo','Cod',False,True,''));
array_push($cp,array('$S50','pr_nome','Nome da impressora',True,True,''));
array_push($cp,array('$S10','pr_fila','Fila',True,True,''));
array_push($cp,array('$S15','pr_ip','Ip',True,True,''));
array_push($cp,array('$D8','pr_install','Dt. instalaзгo',True,True,''));
array_push($cp,array('$T50:5','pr_obs','Observaзгo',False,True,''));
array_push($cp,array('$O 1:SIM&0:NГO','pr_ativa','Ativa',False,True,''));
//array_push($cp,array('$O 1:SIM&0:NГO','pr_ativa','Ativa',False,True,''));
array_push($cp,array('$S100','pr_counter','Endereзo da pбgina da impressora',True,True,''));
array_push($cp,array('$Q pt_modelo:pt_codigo:select * from printers_tipo where pt_ativo=1 order by pt_modelo','pr_tipo','Tipo Impressora',True,True,''));


/// Gerado pelo sistem "base.php" versao 1.0.5
?>
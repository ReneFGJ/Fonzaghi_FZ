<?
require("../db_fghi2.php");
require($include."sisdoc_data.php");

$tabela = "ocorrencias_formulario";
$cp = array();
array_push($cp,array('$H8','id_of','id_of',False,True,''));
array_push($cp,array('$H7','of_codigo','of_codigo',False,True,''));
array_push($cp,array('$T50:5','of_descricao','Descriчуo do problema',False,True,''));
array_push($cp,array('$HV','of_log_solicitante','Log solicitante',True,False,''));
array_push($cp,array('$HV','of_data', 'Data da solicitaчуo',True,false,''));
array_push($cp,array('$HV','of_hora','Hora da solicitaчуo',True,false,''));
array_push($cp,array('$Q ot_nome:ot_log:select ot_log, (ot_nome ||\' ( \'|| ot_area_atendimento ||\' ) \') as ot_nome from ocorrencias_ti where ot_ativo = \'1\' order by ot_nome','of_enviar_para','Enviar para',False,false,''));
array_push($cp,array('$T50:5','of_solucao','Soluчуo',True,True,''));
array_push($cp,array('$D8','of_data_solucao', 'Data em que foi solucionado',True,True,''));
array_push($cp,array('$S5','of_hora_solucao', 'Hora que foi solucionado',True,True,''));
array_push($cp,array('$S10', 'of_log_solucionou', 'Log que solucionou',True,True,''));
?>
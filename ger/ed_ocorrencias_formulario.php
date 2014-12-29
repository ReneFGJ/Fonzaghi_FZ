<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/index_ocorrencias.php','Formulário de ocorrências'));
array_push($breadcrumbs, array('/fonzaghi/ger/ed_ocorrencias_formulario.php','Listagem das ocorrencias'));

$include = '../';
require($include."cab.php");
require($include."sisdoc_menus.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");

require("../db_fghi2.php");

$tabela = "ocorrencias_formulario";
$idcp = "of";
$label = "Listagem das ocorrencias";
$http_edit = 'ed_edit.php'; 
$http_edit_para = '&dd99='.$tabela; 
$http_ver = 'ocorrencias_formulario_ver.php'; 

$editar = true;
$http_redirect = 'ed_'.$tabela.'.php';
$cdf = array($idcp.'_codigo',$idcp.'_descricao',$idcp.'_log_solicitante', $idcp.'_data', $idcp.'_enviar_para', $idcp.'_solucao', $idcp.'_data_solucao', $idcp.'_log_solucionou');
$cdm = array('Código','Descrição','Solicitante', 'Data da solicitação', 'Enviado para', 'Solução', 'Dt. solução', 'Quem solucionou');
$masc = array('','','','D', '','','D','');
$busca = true;
$offset = 20;

$order  = $idcp."_data, ".$idcp."_log_solicitante, ".$idcp."_descricao";

echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
require($include.'sisdoc_row.php');	
echo '</table>';

require($vinclude."foot.php");
?>
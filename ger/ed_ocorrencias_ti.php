<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/index_ocorrencias.php','Formulário de ocorrências'));
array_push($breadcrumbs, array('/fonzaghi/ger/ed_ocorrencias_ti.php','Cadastrar/Alterar Membros da TI'));

$include = '../';
require($include."cab.php");
require($include."sisdoc_menus.php");

require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");

require("../db_fghi2.php");

$tabela = "ocorrencias_ti";
$idcp = "ot";
$label = "Membros da TI";
$http_edit = 'ed_edit.php'; 
$http_edit_para = '&dd99='.$tabela; 
$editar = true;
$http_redirect = 'ed_'.$tabela.'.php';
$cdf = array($idcp.'_codigo',$idcp.'_nome',$idcp.'_log', $idcp.'_ativo', );
$cdm = array('Código','Nome','Log', 'Ativo');
$masc = array('','','','SN');
$busca = true;
$offset = 20;

$order  = $idcp."_nome";

echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
require($include.'sisdoc_row.php');	
echo '</table>';

require($vinclude."foot.php");
?>
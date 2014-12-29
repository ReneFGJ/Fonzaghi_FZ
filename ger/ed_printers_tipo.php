<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/impressora.php','Impressoras'));
array_push($breadcrumbs, array('/fonzaghi/ger/ed_printers_tipo.php','Cadastrar/Alterar tipo de impressora'));

$include = '../';
require($include."cab_novo.php");
require($include."sisdoc_menus.php");

require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");

require("../db_206_printers.php");

$tabela = "printers_tipo";
$idcp = "pt";
$label = "";
$http_edit = 'ed_edit.php'; 
$http_edit_para = '&dd99='.$tabela; 
$editar = true;
$http_redirect = 'ed_'.$tabela.'.php';
$cdf = array($idcp.'_codigo',$idcp.'_modelo',$idcp.'_ativo');
$cdm = array('Código','Modelo','Ativo');
$masc = array('','','SN');
$busca = true;
$offset = 20;

$order  = $idcp."_modelo ";
echo '<h1>Tipos de impressoras</h1><center>';
echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
require($include.'sisdoc_row.php');	
echo '</table>';

require($vinclude."foot.php");
?>
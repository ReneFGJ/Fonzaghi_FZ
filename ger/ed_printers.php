<?
$breadcrumbs=array();
array_push($breadcrumbs, array('../index.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/ger/impressora.php','Impressoras'));
array_push($breadcrumbs, array('/fonzaghi/ger/ed_printers.php','Cadastrar/Alterar impressora'));

$include = '../';
require($include."cab_novo.php");
require($include."sisdoc_menus.php");

require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");

require("../db_206_printers.php");

$tabela = "printers";
$idcp = "pr";
$label = "";
$http_edit = 'ed_edit.php'; 
$http_edit_para = '&dd99='.$tabela; 
$http_redirect = 'ed_'.$tabela.'.php';
$http_ver = 'printers_ver.php'; 

$cdf = array($idcp.'_codigo',$idcp.'_nome',$idcp.'_fila',$idcp.'_ip', $idcp.'_install');
$cdm = array('Código','Nome da impressora','Fila','Ip', 'Dt. instalação');
$masc = array('','','','','D');
$busca = true;
$editar = true;

$offset = 20;
$order  = $idcp."_nome";
echo '<h1>Impressoras</h1><center>';
echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
require($include.'sisdoc_row.php');	
echo '</table>';

require("../foot.php");
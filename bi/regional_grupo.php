<?
$breadcrumbs=array();
array_push($breadcrumbs, array('index.php','Loja'));
array_push($breadcrumbs, array('produto.php','Cadastro de produtos'));

$include = '../';
require("../cab_novo.php");

require($include."sisdoc_colunas.php");
require("../_class/_class_regionais.php");
$rg = new regional;
require('../db_cadastro.php');
echo '<h1>Cadastro de regionais</h1>';

$tabela = ' (
select t2.id_rg as id_rg, t2.rg_codigo as rg_codigo,
		 t1.rg_bairro as grupo, 
		 t2.rg_bairro as categoria
	from '.$rg->tabela.' as t1
	left join '.$rg->tabela.' as t2 on t2.rg_ref = t1.rg_codigo
	where not t2.rg_codigo isnull and t2.rg_ativo = 1
	) as tabela
'
;

$idcp = "rg";

$http_edit = 'regional_grupo_ed.php'; 

$editar = true;
$http_redirect = page();
$cdf = array('id_'.$idcp,'grupo','categoria');
$cdm = array('Código','Regional','Bairro','Ação');
$masc = array('','H','','SN','','');
$busca = true;
$offset = 120;
$tab_max = '99%';

$order  = " grupo, categoria ";

echo '<TABLE width="'.$tab_max.'" align="center"><TR><TD>';
require($include.'sisdoc_row.php');	
echo '</table>';

?>

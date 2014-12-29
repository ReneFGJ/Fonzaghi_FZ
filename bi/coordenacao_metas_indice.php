<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Bussiness Inteligence'));

$include = '../';
require('../cab_novo.php');
$user->le($_SESSION['nw_cracha']); 
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');
require($include.'sisdoc_lojas.php');
require($include."sisdoc_colunas.php");
require($include.'_class_form.php');
$form = new form;
require('../db_bi.php');
require('../_class/_class_metas.php');
$met = new metas;
setft();

$cp = $met->cp_metas_indice();

if (strlen(trim(round($dd[0])))==0)
{
    $dd[2]=date(m);
    $dd[3]=date(Y);
}
$dd[10]=$_SESSION['nw_user'];
$dd[5]=str_replace(',','.',$dd[5]);
$dd[11]=date('Ymd');

$tela = $form->editar($cp,'metas_indice');

echo '<center><h1>Cadastro de metas</h1>';
    $tabela = 'metas_indice';
    $editar = True;
    $http_redirect = 'coordenacao_metas_indice.php';
    $met->row_metas_indice();
    $busca = true;
    $offset = 10;

$tab_max = "100%";
echo '<div id="content">';
    echo '<TABLE width="100%" align="center"><TR><TD>';
    require($include.'sisdoc_colunas.php');
    require($include.'sisdoc_row.php'); 
    echo '</table>';    
echo '</div>';

/* Rodape */
echo $hd->foot();
?>
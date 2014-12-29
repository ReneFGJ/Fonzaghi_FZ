<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Bussiness Inteligence'));

$include = '../';
require('../cab_novo.php');
$user->le($_SESSION['nw_cracha']); 
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');
require($include.'_class_form.php');
$form = new form;
require('../_class/_class_metas.php');
require('../db_bi.php');
$met = new metas;
$cp = $met->cp_metas_geral();

$dd[5]=$_SESSION['nw_user'];
$dd[1]=str_replace(',','.',$dd[1]);
$dd[6]=date('Ymd');

$tela = $form->editar($cp,'metas_geral');

echo '<h1>Cadastro de metas</h1>';
    $tabela = 'metas_geral';
    $editar = True;
    $http_redirect = 'coordenacao_metas_geral.php';
    $met->row_metas_geral();
    $busca = true;
    $offset = 8;

$tab_max = "100%";
echo '<div id="content">';
    echo '<TABLE width="98%" align="center"><TR><TD>';
    require($include.'sisdoc_colunas.php');
    require($include.'sisdoc_row.php'); 
    echo '</table>';    
echo '</div>';

/* Rodape */
echo $hd->foot();
?>
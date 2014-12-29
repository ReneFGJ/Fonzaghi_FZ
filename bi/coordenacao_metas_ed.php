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
require('../db_bi.php');
require('../_class/_class_metas.php');
$met = new metas;
$cp = $met->cp_metas();
$tela = $form->editar($cp,'metas');

    $tabela='metas';
    $editar = True;
    $http_redirect = 'coordenacao_metas.php';
    $met->row_metas();
    $busca = true;
    $offset = 5;

$tab_max = "100%";
echo '<h1>Cadastro metas</h1>';

if ($form->saved  > 0)
    {
        $met->updatex_metas();
        redirecina("coordenacao_metas.php");
    }else{
        echo $tela;
    }
   
/* Rodape */
echo $hd->foot();
?>
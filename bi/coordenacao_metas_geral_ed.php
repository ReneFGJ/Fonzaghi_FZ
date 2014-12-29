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
$cp = $met->cp_metas_geral();

$dd[5]=$_SESSION['nw_user'];
$dd[1]=str_replace(',','.',$dd[1]);
$dd[6]=date('Ymd');

$tela = $form->editar($cp,'metas_geral');

$tabela='metas_geral';
$editar = True;
$http_redirect = 'coordenacao_metas_geral.php';
$met->row_metas_geral();
$busca = true;
$offset = 8;
$http_edit = 'coordenacao_metas_geral_ed.php'; 

$tab_max = "100%";
echo '<h1>Cadastro metas</h1>';
    if ($form->saved  > 0)
    {
        redirecina("coordenacao_metas_geral.php");
    }else{
        echo $tela;
    }
   
   
/* Rodape */
echo $hd->foot();
?>
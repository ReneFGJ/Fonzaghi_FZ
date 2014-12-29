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
require($include.'_class_form.php');
$form = new form;
require('../db_bi.php');
require('../_class/_class_metas.php');
$met = new metas;
$cp = array();
setft();
array_push($cp,array('$H8','id_met','',false,True));

$tela = $form->editar($cp,'');
    
echo '<h1>Cadastro metas diário</h1>';

if ($form->saved  > 0)
    {
        $met->pesquisa_datas();
    }else{
        echo $tela;
    }
   
/* Rodape */
echo $hd->foot();
?>
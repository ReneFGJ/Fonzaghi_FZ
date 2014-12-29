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

$cp = array();
array_push($cp,array('$H8','','',false,True));//grs
$grs=$dd[0];
$modelo='AreaChart';
$titulo=$dd[1];

echo '<h1>Gráfico mensal de metas</h1>';
echo '<div id="content">';
echo $met->grafico_dinamico($grs, $modelo, $titulo);

echo '</div>';

/* Rodape */
echo $hd->foot();
?>
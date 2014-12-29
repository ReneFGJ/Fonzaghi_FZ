<?php
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Bussiness Inteligence'));

$include = '../';
require("../cab_novo.php");

require($include.'sisdoc_menus.php');

$menu = array();
/////////////////////////////////////////////////// MANAGERS

array_push($menu,array('Consultoras','Concentração por bairro','consultoras_bairro.php'));
array_push($menu,array('Mapa Georeferencial','Concentração por bairro','regional.php'));
array_push($menu,array('Mapa Georeferencial','Cadastro de regionais','regional_grupo.php'));
array_push($menu,array('Mapa Georeferencial','Visualização','geocode_google_mapv3_regional.php'));


$tela = menus($menu,"3");

echo $hd->foot();
?>

<?php
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Bussiness Inteligence'));

$include = '../';
require("../cab.php");
REQUIRE($include.'sisdoc_data.php');

require("../_db/db_cadastro.php");
require("../_class/_class_consultora.php");
$cn = new consultora;

echo '<H2>Busca por consultora</h2>';
echo $cn->form_busca();


echo $cn->resultado_mostra('acordo_mostrar.php');

echo $hd->foot();
?>

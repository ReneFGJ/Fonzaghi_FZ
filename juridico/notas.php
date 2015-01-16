<?php
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Bussiness Inteligence'));

$include = '../';
require("../cab.php");
REQUIRE($include.'sisdoc_data.php');
echo '<BR><BR>';
REQUIRE($include.'sisdoc_debug.php');

require("../_db/db_cadastro.php");
require($include_class."_class_duplicatas.php");
$np = new duplicatas;



require("../_db/db_promissoria.php");

$di = 2;
$df = 10;

$di = round($dd[1]);
$df = round($dd[2]);

echo "<h1>Notas Promissórias Atrasadas entre $di e $df dias</h1>";

echo $np->notas_abertas($di,$df);

echo $hd->foot();
?>

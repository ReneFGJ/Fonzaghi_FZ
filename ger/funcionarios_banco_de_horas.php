<?php
$breadcrumbs=array();
$include = '../';
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
require("../cab_novo.php");
require($include.'sisdoc_data.php');
require("../_class/_class_banco_de_horas.php");
$banco = new banco_de_horas;
require("../db_drh.php");
$cracha = $_SESSION['nw_cracha'];
$banco->carrega_banco_de_horas();
echo $banco->mostra_banco_de_horas_geral($cracha);
$hd->foot();
?>

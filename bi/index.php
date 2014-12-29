<?php
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Bussiness Inteligence'));

$include = '../';
require("../cab.php");
echo '<BR><BR>';
require($include.'sisdoc_menus.php');

$menu = array();
/////////////////////////////////////////////////// MANAGERS
$tabmax = '100%';
   if ($perfil->valid('#MST#DIR#SSS#CCC#CMK'))
    {
        array_push($menu,array('Faturamento & Recebimento','Recebimento',$http.'ger/recebimentos.php'));
    }
	

$tela = menus($menu,"3");

echo $hd->foot();
?>

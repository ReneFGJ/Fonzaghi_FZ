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
$tab_max = '98%';
   if ($perfil->valid('#MST'))
    {
    	array_push($menu,array('Acordo','Abrir acordo','acordo.php'));
		
        array_push($menu,array('Juridico','Notas atrasadas 2-9 dias','notas.php?dd1=2&dd2=9'));
		array_push($menu,array('Juridico','Notas atrasadas 10-30 dias','notas.php?dd1=10&dd2=30'));
		array_push($menu,array('Juridico','Notas atrasadas acima de 30 dias','notas.php?dd1=31&dd2=9999'));
		
		array_push($menu,array('Notas no SPC','Notas no SPC','notas_spc.php'));		
    }
	

$tela = menus($menu,"3");

echo $hd->foot();
?>

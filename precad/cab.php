<?php
$style_add = array('fz_stytecab_top.css','fz_style_cad_pre.css','fz_style_cpf.css');
$top_cab = array();
array_push($top_cab,array('PRÉ-CADASTRO','pre_cadastro.php'));
$include = '../';
require("../cab.php");
echo $hd->cab_extend();
require("../cab_top_menu.php");
?>
<div class="pre_titulo">Pré-Cadastro</div>


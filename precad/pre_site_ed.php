<?php
require("cab.php");

require($include.'sisdoc_tips.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
require ($include . '_class_form.php');
require("../_class/_class_cadastro_pre_site.php");
$pre = new cadastro_pre_site;
$form = new form;

require("../../_db/db_mysql_".$ip.".php");
$tabela = 'cad_site';
$cp = $pre->cp();
$id = $dd[0];
$tela .=  '<div class="noprint">'.$form -> editar($cp, $tabela).'</div>';
$tela .='<h3>Cadastro via site</h3>';
$tela .= $pre->mostra($id);

$dd[1]=$_SESSION['nw_log'];

if ($form -> saved > 0) {
	redirecina('pre_site.php');
}else{
	echo $tela;
}
?>

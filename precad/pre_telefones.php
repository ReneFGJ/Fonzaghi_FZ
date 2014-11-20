<?php
require("cab.php");

require($include.'sisdoc_tips.php');
require($include.'sisdoc_data.php');
//require($include.'sisdoc_debug.php');

require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

require("../../_db/db_mysql_".$ip.".php");

$editar = false;
$http_redirect = 'pre_telefones.php';
$http_ver = 'pre_telefones_ed.php';

$pre_where = '' ;
$pre->row_telefones();
$busca = true;
$offset = 20;
$tab_max = "100%";

echo '<h3>Alteração de telefones</h3>';
echo '<div>';
echo '<TABLE width="98%" align="center"><TR><TD>';
		require($include.'sisdoc_colunas.php');
 		require($include.'sisdoc_row.php');	
echo  '</table>';	
echo '</div>';
?>


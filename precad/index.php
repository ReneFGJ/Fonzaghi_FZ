<?php	
require("cab.php");
require("../_class/_class_cadastro_pre.php");
//require ($include . "sisdoc_debug.php");
require ($include . "sisdoc_data.php");
$pre = new cadastro_pre;

echo '<table><tr><td valign="top" width="60%">'.$pre->formulario_de_busca(100).'</td>';
require ("../../_db/db_206_telemarket.php");
echo '<td valign="top" width="40%">'.$pre->agendados(100).'</td></tr>';
require ("../../_db/db_mysql_" . $ip . ".php");
echo '<tr><td colspan="2">'.$pre->mostra_informacoes_uteis().'</td></tr>';
?>
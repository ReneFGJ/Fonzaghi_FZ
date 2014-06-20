<?php
require('cab.php');
require($include.'sisdoc_data.php');
require("../_class/_class_cadastro_pre_consultora.php");
$cons = new cadastro_pre_consultora;
echo '<H1>Busca consultora</h1>';
if (strlen($dd[1]) == 0)
	{
		echo $cons->form_busca();
	} else {
		/* Mostra resultados */
		require ("../../_db/db_mysql_10.1.1.220.php");
		echo $cons->resultado_mostra($http_site.'/pre_cadD.php');
	}

echo '<BR><div style="height: 800px;">';
?>

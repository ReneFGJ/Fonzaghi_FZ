<?php
require("cab.php");
//require($include . "sisdoc_debug.php");
require($include.'sisdoc_data.php');
require("../_class/_class_cadastro_pre_importacao.php");
$imp = new cadastro_pre_importacao;
$include_db='../../_db/';

require ($include_db."db_mysql_" . $ip . ".php");

	
require($include_db.'db_cadastro.php');
$imp->gera_query_insert()
	
?>
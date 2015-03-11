<?php
require("cab.php");
require ($include . "sisdoc_debug.php");
require($include.'sisdoc_data.php');
require("../_class/_class_cadastro_pre_site.php");
$pre = new cadastro_pre_site;
echo $pre->lista();






		

	
?>


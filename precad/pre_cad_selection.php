<?php
require("cab.php");

require($include.'sisdoc_data.php');
require($include.'_class_form.php');

require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

$pre->le($dd[0]);
$cliente = $pre->cliente;

echo $cliente;
if (strlen($cliente) == 7)
	{
		$_SESSION['PG1_DD0'] = $cliente;
		$_SESSION['page'] = '1';
		redirecina('pre_cad.php');		
	} else {
		echo 'Código Inválido';
	}
?>

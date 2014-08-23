<?php
require("cab.php");
require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

if (strlen($dd[1].$dd[2]) > 0)
	{
		$nome = $dd[1];
		$cpf = $dd[2];
		echo $pre->busca_nome($nome,$cpf);
	} else {
		echo $pre->formulario_de_busca();
	}
?>

<script>
	jQuery(function($){
   		$("#dd2").mask("999.999.999-99");
	});
</script>
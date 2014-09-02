<?php
require("cab.php");
require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;

require($include.'sisdoc_data.php');

if (strlen($dd[1].$dd[2]) > 0)
	{
		$nome = $dd[1];
		$cpf = $dd[2];
		echo $pre->busca_nome($nome,$cpf);
		
		if (($pre->total_result == 0) and (strlen($dd[2]) > 0))
			{
				echo '<h2>CPF não localizado no cadastro</h2>';
				echo '<font class="lt4">CPF: '.$dd[2];
				echo '<form method="post" action="pre_cadastro_consulta_cpf.php">';
				echo '<input type="hidden" value="'.sonumero($dd[2]).'" name="dd1">';
				echo '<input type="submit" value="Consultar CPF na ACP >>>"  class="precad_form_submit" style="width: 300px;">';
				echo '</form>';
				//$pre->cadastrar_cpf($cpf);		
			}
		
	} else {
		echo $pre->formulario_de_busca();
	}
?>

<script>
	jQuery(function($){
   		$("#dd2").mask("999.999.999-99");
	});
</script>
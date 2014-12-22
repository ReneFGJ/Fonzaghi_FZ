<?php
require("cab.php");

require($include.'sisdoc_tips.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_debug.php');
require ($include . '_class_form.php');
require("../_class/_class_geocode.php");
require("../_class/_class_cadastro_pre.php");
$pre = new cadastro_pre;
$form = new form;

require("../../_db/db_mysql_".$ip.".php");
$tabela = 'cad_endereco';
$cp = $pre->cp_endereco();

$tela .=  $form -> editar($cp, $tabela);

$cliente = $dd[1];
echo '<h3>Alteração de endereço - consultora('.$cliente.')</h3>';
if ($form -> saved > 0) {
	$id = $dd[0];
	$status = $dd[11];
	$login = $_SESSION['nw_user'];
	$acao = "205 - ATUALIZOU ENDERECO ID ".$id;
	$acao_cod = '205';
	$pre->inserir_log($cliente, $login, $acao,$acao_cod, $status);
	redirecina('pre_enderecos.php');
}else{
	echo $tela;
}
?>

<div id="cep_busca"></div>
	<script>
	$(document).ready(function(){
		$("#dd4").focusout(function(){
			var cep = $("#dd4").val(); 
			$.ajax({
				type : "POST",
				url : "../_ajax/ajax_pre_cad.php",
				data : {
					dd0 : cep,
					dd1 : "CEP_BUSCA",
				}
			})
			.fail(function() { alert("error"); })
			.done(function(data) {
				$("#cep_busca").html(data);
			});
		});
	});	
	</script>
				

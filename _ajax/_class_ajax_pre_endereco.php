<?php
require("../_class/_class_cadastro_pre.php");
require ("../_class/_class_geocode.php");

class ajax
	{
		var $tabela = '';
		function __construct()
			{
		//		$cad = new cadastro_pre;
		//		$this->tabela = $cad->tabela_telefone;
			}
		function cp()
			{
				global $dd,$acao;
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$cp = $cad->cp_endereco();
				/*ajax para busca de dados via CEP*/
				echo '<div id="cep_busca"></div>
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
				';
				return($cp);
			}	
		function insere_registro($dd)
			{
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$cep = $dd[4];
				$rua = strtoupper($dd[5]);
				$numero = $dd[6];
				$complemento = strtoupper($dd[7]);
				$bairro = strtoupper($dd[8]);
				$cidade = strtoupper($dd[9]);
				$estado = $dd[10];
				$long = $dd[13];
				$lat = $dd[14];
				$cad->insere_endereco($rua,$numero,$complemento,$cep,$bairro,$cidade,$estado,$long,$lat);
			}
		function refresh()
			{
				global $dd,$editar;
				$editar = 0;
				if ($_SESSION['PG1_DD0'] == $dd[1]) { $editar = 1; }
				$cad = new cadastro_pre;
				$cad->cliente = $dd[1];
				$sx = $cad->lista_endereco_mostra($dd[1],$editar);
				
				
				return($sx);
			}
	}
?>
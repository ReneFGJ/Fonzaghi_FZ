<?php
require ("../_class/_class_vendas_funcionario.php");
require ("../../_db/db_fghi.php");
require ($include.'sisdoc_data.php');
 
if(strlen(trim($dd[5]))>3){
	$verb = 'NEW';
	$dd[2]=$verb;
	
}
  
class ajax {
	var $tabela = '';
	function __construct() {
		//		$cad = new cadastro_pre;
		//		$this->tabela = $cad->tabela_telefone;
	}

	function cp() {
		return ($cp);
	}

	function vende_produto_cracha($cracha,$produto)
		{
			
		}
	function insere_registro($dd){
		$ean13 = $dd[5];
		
		$venda = new vendas_funcionario;
		$sx = $venda->salva_produto($ean13);
		$form = new form;
		$sx .= $form->ajax('venda_resumo','');
		$sx .= $form->ajax('produtos_venda','');
		$sx .= $venda->erro;
		return($sx);
	}
	function refresh() {
		global $dd;

		$form = new form;
		$form -> ajax = 1;
		$form -> frame = 'produtos_venda';
		$form -> required_message = 0;
		$form -> required_message_post = 0;
		$form -> class_string = 'fz_precad_form_string';
		$form -> class_button_submit = 'fz_precad_form_submit';
		$form -> class_form_standard = 'fz_precad_form';
		$form -> class_textbox = 'fz_precad_form_string';
		$form -> class_memo = 'fz_precad_form';
		$form -> class_select = 'fz_precad_select';		
		
		$produto = $dd[5];
		$cracha = $dd[1];
		
		if (strlen($produto) > 0)
			{
				$this->vende_produto_cracha($cracha,$produto);
				echo $form->ajax('venda_resumo',$cracha);
			}

		$cp = array();
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$H8', '', '', False, False));
		array_push($cp, array('$EAN', '', 'Produto', True, True));
		$tela = $form -> editar($cp, '');
		echo $tela;
		echo $erro;
		return ($sx);
	}

}
?>

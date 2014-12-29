<?php
$breadcrumbs = array();
array_push($breadcrumbs, array('index.php','Loja'));
array_push($breadcrumbs, array('produto.php','Cadastro de produtos'));
array_push($breadcrumbs, array('produto_ed.php','Edição de produto'));

$include = '../';
require('../cab_novo.php');

require($include.'sisdoc_debug.php');
require("../_class/_class_regionais.php");

global $acao,$dd,$cp,$tabela;
require($include.'sisdoc_colunas.php');
require($include.'_class_form.php');
$form = new form;
require('../db_cadastro.php');
require($include.'sisdoc_data.php');

$rg = new regional;
$cp = $rg->cp();
$tabela = $rg->tabela;

$http_edit = page();
$http_redirect = '';
$tit = 'Cadastro de Atributos';

		if(strlen($dd[3])>0){
			$dd[2] = 'Regional - '.$dd[2];
		}

/** Comandos de Edição */
$tela = $form->editar($cp,$tabela);
echo '<center>';
/** Caso o registro seja validado */
if ($form->saved > 0)
	{
		$rg->updatex();
		redirecina('regional_grupo.php');
	} else {
		echo $tela;
		$sx = $rg->lista_regionais();
		$i=1;
		echo '<table width="95%"><tr valign="top">';
		while($i<=count($sx)){
			echo '<td>'.$sx[$i].'</td>';
			$i++;
			$j++;
			if($j==4){ $j=0; echo '<tr valign="top">'; }
		}
		echo '</table>';
	}
		
?>


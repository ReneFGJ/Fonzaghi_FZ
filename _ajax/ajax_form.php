<?php
$include = '../';
$include_db = '../../';
require('../db.php');
require($include.'_class_form.php');

$form = new form;
$form->ajax = 1;
$form->form_name = $dd[91];
$form->frame = 'ajax_'.$dd[91];

$class = trim($dd[91]);
$proto = trim($dd[1]);
$verb = uppercase($dd[2]);

if (strlen($class) > 0)
	{
		require("../_ajax/_class_ajax_".$class.".php");
		$ajax = new ajax;
		$tabela = $ajax->tabela;
	}

switch($verb)
	{
	case 'REFRESH2':
			$sx .= $form->ajax_refresh($class,$proto);
			break;
	case 'REFRESH':
			$sx .= '<div style="display:  table;">';
			$sx .= $ajax->refresh();
			$sx .= '</div>';
			break;
	case 'NEW':
			$cp = $ajax->cp();
			$tela = $form->editar($cp,'');
			if ($form->saved > 0)
				{
					$ajax->insere_registro($dd);
					redirecina(page().'?dd1='.$dd[1].'&dd2=REFRESH2&dd91='.$dd[91]);
				}
			$sx = $tela;  
			break;
	case 'list': $sx = 'LISTA'; break;
	default:
			$sx .= 'VERB NOT INFORMED';
			break;
	}
echo $sx;
?>
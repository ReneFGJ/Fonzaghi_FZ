<?php
$include = '../';
$include_db = '../../';
require('../db.php');
require($include.'_class_form.php');
//require ($include.'sisdoc_debug.php');


$editar = $dd[95];

$form = new form;
$form->ajax = 1;
$form->form_name = $dd[91];
$form->frame = 'ajax_'.$dd[91];

$class = trim($dd[91]);
$proto = trim($dd[1]);
$verb = uppercase($dd[2]);

//echo date("Y-m-d H:i:s");

if (strlen($class) > 0)
	{
		$file = "../_ajax/_class_ajax_".$class.".php";
		if (file_exists($file))
			{
			require($file);
			$ajax = new ajax;
			$tabela = $ajax->tabela;
			} else {
				echo 'Class not found <B>'.$file.'</B>';
				exit;
			}
	}

switch($verb)
	{
	case 'REFRESH2':
			$sx .= $form->ajax_refresh($class,$proto,$editar);
			break;
	case 'REFRESH':
			$sx .= '<div style="display: table;">';
			$sx .= $ajax->refresh();
			$sx .= '</div>';
			break;
	case 'NEW':
			//codigo comentado é do sistema precadastro verificar com rene o que fazer 
			
			/*$cp = $ajax->cp();
			$tela = $form->editar($cp,'');
			if($form->saved >0){
				$ajax->insere_registro($dd);
				redirecina(page().'?dd1='.$dd[1].'&dd2=REFRESH2&dd91='.$dd[91]);
			}
			$sx = $tela;
			 * 
			 */
		
		
			$sx .= $ajax->insere_registro($dd);
			break;
	case 'list': $sx = 'LISTA'; break;
	default:
			$sx .= 'VERB NOT INFORMED';
			$sx .= '<BR>dd2=verb';
			$sx .= '<BR>dd1=protocol';
			$sx .= '<BR>dd91=class';
			break;
	}
echo $sx;
?>
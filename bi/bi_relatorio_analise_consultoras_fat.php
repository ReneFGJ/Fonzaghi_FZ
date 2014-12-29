<?
$breadcrumbs = array();
$include = '../';

require ("../cab_novo.php");
require ($include . "sisdoc_lojas.php");
require ($include . "sisdoc_data.php");
require ('../_class/_class_consultora_ativa.php');
require ('../_class/_class_bi.php');
$bi = new bi;
require($include.'_class_form.php');
$form = new form;
$cp = array();

setlj2();

array_push($cp,array('$D','','Data inicial',False,True));
array_push($cp,array('$D','','Data final',False,True));
echo '<h1>Relatório de faturamento por consultora</h1>';
$tela = $form->editar($cp,'');

if ($form->saved > 0)
	{
		echo $tela;
		$dt1 = dataExt($dd[0],'br');;
		$dt2 = dataExt($dd[1],'br');;
		$bi -> obtem_dados_faturamento_consultora($dt1['en'],$dt2['en']);
		echo $bi->monta_tabela();
	} else {
		echo $tela;
	}

/* Rodape */
echo $hd->foot();
?>
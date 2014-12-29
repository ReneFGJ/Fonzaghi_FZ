<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Bussiness Inteligence'));

$include = '../';
require('../cab_novo.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');
require($include.'_class_form.php');
$form = new form;

require('../db_fghi_206_recepcao.php');

require('../_class/_class_fluxo_atendimento.php');
$flx = new fluxo_atendimento;

$cp = $flx->cp();

$tela = $form->editar($cp,'');

$tab_max = "100%";
echo '<h1>Fluxo de atendimento</h1>';

if ($form->saved  > 0)
    {
        echo $tela;
		$d1 = substr($dd[0],-4).substr($dd[0],3,2).substr($dd[0],0,2);
		$d2 = substr($dd[1],-4).substr($dd[1],3,2).substr($dd[1],0,2);
		$flx->gerar_relatorio($d1,$d2);
		echo $flx->tela;
    }else{
        echo $tela;
    }
   
/* Rodape */
echo $hd->foot();
?>
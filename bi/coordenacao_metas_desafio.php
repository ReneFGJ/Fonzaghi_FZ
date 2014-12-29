<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/bi/index.php','Bussiness Inteligence'));

$include = '../';
require('../cab_novo.php');
$user->le($_SESSION['nw_cracha']); 
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');
require($include.'sisdoc_lojas.php');
require($include."sisdoc_colunas.php");
require($include.'_class_form.php');
$form = new form;
require('../db_bi.php');
require('../_class/_class_metas.php');
$met = new metas;
setlj();
$cp = array();
array_push($cp,array('$H8','','',False,False));
array_push($cp,array('$D ','','Data',false,True));

$tela = $form->editar($cp,'');
    
echo '<h1>Desafio por setor '.$dd[1].'</h1>';

if ($form->saved  > 0)
    {
        $data = $dd[1];
         echo utf8_decode($met->desafios_setor($data));
    }else{
        echo $tela;
    }

   
/* Rodape */
echo $hd->foot();
?>
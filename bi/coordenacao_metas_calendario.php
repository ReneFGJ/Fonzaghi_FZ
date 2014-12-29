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
setft();
if (strlen($dd[1])==0) 
{
    $dd[1]=date(m);
}
if (strlen($dd[2])==0) 
{
    $dd[2]=date(Y);
}
$cp = array();
array_push($cp,array('$H8','','',False,False));
array_push($cp,array('$O 01:JANEIRO&02:FEVEREIRO&03:MARÇO&04:ABRIL&05:MAIO&06:JUNHO&07:JULHO&08:AGOSTO&09:SETEMBRO&10:OUTUBRO&11:NOVEMBRO&12:DEZEMBRO','','Mês :',True,True));
array_push($cp,array('$O '.date("Y").':'.date("Y").'&'.
                           (date("Y")-1).':'.(date("Y")-1).'&'.
                           (date("Y")-2).':'.(date("Y")-2).'&'.
                           (date("Y")-3).':'.(date("Y")-3).'&'.
                           (date("Y")-4).':'.(date("Y")-4).'&'.
                           (date("Y")-5).':'.(date("Y")-5).'&'.
                           (date("Y")-6).':'.(date("Y")-6).'&'.
                           (date("Y")-7).':'.(date("Y")-7)
                           ,'','Ano :',True,True));
echo '<link rel="stylesheet" type="text/css" href="'.$hd->http.'css/style_calender.css" />';
$tela = $form->editar($cp,'');
echo '<h1>Cadastro metas diário</h1>';
if ($form->saved  > 0)
    {
        $mes = $dd[1];
        $ano = $dd[2];
        $lj = $dd[3];
        //$met->pesquisa_datas();
        echo $met->calendario_metas($mes,$ano);
    }else{
        echo $tela;
    }
/* Rodape */
echo $hd->foot();
?>
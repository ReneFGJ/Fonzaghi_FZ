<?
$breadcrumbs = array();
$include = '../';

require ("../cab_novo.php");
require ($include . "sisdoc_data.php");
require ($include . "sisdoc_lojas.php");
require ('../_class/_class_form.php');
$form = new form;
require ('../_class/_class_bi.php');
$bi = new bi;

$lojas = array();
$mes1 = array();
$mes2 = array();
$ano = array();

$cp = array();

array_push($cp,array('$O 0:Joias&1:Modas&2:Oculos&3:Use Brilhe&4:Sensual&5:Ex modas&6:Ex joias','','Loja',True,True,''));
array_push($cp,array('$D','','Inicio',True,False,''));
array_push($cp,array('$D','','Fim',True,False,''));
array_push($cp,array('$S7','','Consultora',False,False,''));

$tela = $form->editar($cp,'');

if ($form->saved > 0){
	setlj2();
	$dt1 = $dd[1];
	$dt2 = $dd[2];
	$dtx1 = dataExt($dt1,'br');
	$dtx2 = dataExt($dt2,'br');
	$ljx = $dd[0];
	$cons = $dd[3];
	
	require ('../' . $setlj[3][$ljx]);
	echo '<h1> Analise de vendas por consultora - ' . $dtx1['m'] . '/' . $dtx1['y'] . ' a ' . $dtx2['m'] . '/' . $dtx2['y'] . '</h1>';	
	echo '<div class="noprint"><br><br><br>';
	echo $tela;
	echo '<center><a href="bi_relatorio_analise_consultoras_excel.php?dd0='.$dd[0].'&dd1='.$dd[1].'&dd2='.$dd[2].'&dd3='.$dd[3].'&dd4='.$dd[4].'"><img width="40px" src="../img/excel.png"></a>';
	echo '</div><div style="float:center;"><center>';
	echo $bi -> analisar_consultoras_por_periodo($dt1, $dt2, $ljx,$cons);
} else {
	echo '<div><br><br><br>';
	echo $tela;
	echo '</div><div style="float:center;"><center>';
	echo '<h1> Analise de vendas</h1>';
	echo '<table width="98%" align="center">';
	echo '</table></center>';

}
echo $hd -> foot();
?>
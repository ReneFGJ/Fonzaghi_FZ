<?
$breadcrumbs = array();
$include = '../';

require ("../cab_novo.php");
require ($include . "sisdoc_lojas.php");
require ('../_class/_class_botoes.php');
$bot = new form_botoes;
require ('../_class/_class_bi.php');
$bi = new bi;

if (strlen(trim($dd[1])) == 0) { $dd[1] = 01;
};
if (strlen(trim($dd[2])) == 0) { $dd[2] = 12;
};
if (strlen(trim($dd[3])) == 0) { $dd[3] = date('Y');
};
if (strlen(trim($dd[4])) == 0) { $dd[4] = 0;
};

$lojas = array();
$mes1 = array();
$mes2 = array();
$ano = array();

array_push($lojas, array(' Joias', '0'));
array_push($lojas, array(' Modas', '1'));
array_push($lojas, array(' Oculos', '2'));
array_push($lojas, array(' Use Brilhe', '3'));
array_push($lojas, array(' Sensual', '4'));
array_push($lojas, array(' Ex modas', '5'));
array_push($lojas, array(' Ex joias', '6'));

array_push($mes1, array('(01)Janeiro', '01'));
array_push($mes1, array('(02)Fevereiro', '02'));
array_push($mes1, array('(03)Marco', '03'));
array_push($mes1, array('(04)Abril', '04'));
array_push($mes1, array('(05)Maio', '05'));
array_push($mes1, array('(06)Junho', '06'));
array_push($mes1, array('(07)Julho', '07'));
array_push($mes1, array('(08)Agosto', '08'));
array_push($mes1, array('(09)Setembro', '09'));
array_push($mes1, array('(10)Outubro', '10'));
array_push($mes1, array('(11)Novembro', '11'));
array_push($mes1, array('(12)Dezembro', '12'));

array_push($mes2, array('(01)Janeiro', '01'));
array_push($mes2, array('(02)Fevereiro', '02'));
array_push($mes2, array('(03)Marco', '03'));
array_push($mes2, array('(04)Abril', '04'));
array_push($mes2, array('(05)Maio', '05'));
array_push($mes2, array('(06)Junho', '06'));
array_push($mes2, array('(07)Julho', '07'));
array_push($mes2, array('(08)Agosto', '08'));
array_push($mes2, array('(09)Setembro', '09'));
array_push($mes2, array('(10)Outubro', '10'));
array_push($mes2, array('(11)Novembro', '11'));
array_push($mes2, array('(12)Dezembro', '12'));

array_push($ano, array(date('Y'), date('Y')));
array_push($ano, array(date('Y') - 1, date('Y') - 1));
array_push($ano, array(date('Y') - 2, date('Y') - 2));
array_push($ano, array(date('Y') - 3, date('Y') - 3));

$tela .= $bot -> action('bi/bi_relatorio_analise_consultoras.php', 0);
$tela .= $bot -> mostrar_botoes($mes1);
$tela .= $bot -> mostrar_botoes($mes2);
$tela .= $bot -> mostrar_botoes($ano);
$tela .= $bot -> mostrar_botoes($lojas);
$tela .= $bot -> submit();

if (strlen($acao) > 0) {
	setlj2();

	$m1 = $dd[1];
	$m2 = $dd[2];
	$a = $dd[3];
	$ljx = $dd[4];
	require ('../' . $setlj[3][$ljx]);
	echo '<h1> Analise de vendas por consultora - ' . $m1 . '/' . $a . ' a ' . $m2 . '/' . $a . '</h1>';	
	echo '<div class="noprint"><br><br><br>';
	echo $tela;
	echo '<a href="bi_relatorio_analise_consultoras_excel.php?dd1='.$dd[1].'&dd2='.$dd[2].'&dd3='.$dd[3].'&dd4='.$dd[4].'"><img width="40px" src="../img/excel.png"></a>';
	echo '</div><div style="float:center;"><center>';
	echo $bi -> analisar_consultoras_por_periodo($m1, $m2, $a, $ljx);
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
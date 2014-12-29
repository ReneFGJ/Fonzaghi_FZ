<?
$breadcrumbs=array();
array_push($breadcrumbs, array('index.php','Loja'));
array_push($breadcrumbs, array('acertos_periodo.php','Acertos'));

$include = '../';
require("../cab_novo.php");
require($include.'sisdoc_data.php');
require('../_class/sisdoc_lojas.php');

require("../_class/_class_consignacoes.php");
$cons = new consignacoes;

setlj();

echo '<img src="img/logo_empresa.png" height="80" alt="" border="0" align="right">';
echo '<h1>Análise de Acertos Lojas - '.date("d/m/Y H:i").'</h1>';

$t1 =0;
$t2 =0;
$t3 =0;
$tela = '';
for ($r=0; $r < 7; $r++)
	{
		$tela .= '<font class="lt5">'.$setlj[1][$r].'</font>';
		
		require("../".$setlj[3][$r]);
		$tela .= '<BR>'.$setlj[2][$r];
		$d1 = date("Ymd");
		$d2 = date("Ymd");
		$tela .= $cons->acertos_resumo($d1, $d2);
		$t1 = $t1 + $cons->v1;
		$t2 = $t2 + $cons->v2;
		$t3 = $t3 + $cons->v3;
	}

echo '<h2>Resultado Diário</h2>';
echo '<table width="50%" align="center" border=0>';
	echo '<TR>
			<TH>Acertos Geral
			<TH>Total Geral
			<TH>Zerados
			';
	echo '<TR class="lt5">
			<TD align="center" class="tabela01">'.$t1.'
			<TD align="center" class="tabela01">'.fmt($t2,2).'
			<TD align="center" class="tabela01">'.$t3.'
		';
echo '</table>';

echo '<h2>Resultado Diário - Detalhado</h2>';
echo $tela;
echo $hd->foot();
?>



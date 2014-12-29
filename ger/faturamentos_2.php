<?
$include = '../';
require($include."cab_novo.php");
require($include."sisdoc_debug.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");
require($include."google_chart.php");
require($include."sisdoc_grafico.php");
require("../db_fghi_210.php");
$loja = $dd[0];
$eqi  = $dd[1];

$mes = date("m");
$ano = date("Y");

$mesi = "07";
$anoi = "2009";

if ($loja == 'J')
	{ $nloja = "02"; $mloja = "Semi-joias"; }

if ($loja == 'M')
	{ $nloja = "03"; $mloja = "Intima"; }

if ($loja == 'O')
	{ $nloja = "04"; $mloja = "Oculos";}

if ($loja == 'U')
	{ $nloja = "05"; $mloja = "UseBrilhe"; }

if ($loja == 'S')
	{ $nloja = "01"; $mloja = "Boutique Sensual"; }

if ($loja == 'D')
	{ $nloja = "09"; $mloja = "Juridico"; }
	
if ($loja == 'S')
	{ $nloja = "01"; $mloja = "Sensual";  }	
	
$ok=0;
$sql = '';

if (strlen($nloja) == 0)
	{
	$sql  = "select sum(round(dp_valor)) as total, round(dp_data/100) as data, 'J' as loja from duplicata_joias where round(dp_data/100) = '".$dd[2]."' and dp_boleto = '' and dp_lote <> ''  group by data ";
	$sql .= " union ";
	$sql .= "select sum(round(dp_valor)) as total, round(dp_data/100) as data, 'M' as loja from duplicata_modas where round(dp_data/100) = '".$dd[2]."' and dp_boleto = '' and dp_lote <> '' group by data ";
	$sql .= " union ";
	$sql .= "select sum(round(dp_valor)) as total, round(dp_data/100) as data, 'O' as loja from duplicata_oculos where round(dp_data/100) = '".$dd[2]."' and dp_boleto = '' and dp_lote <> '' group by data ";
	$sql .= " union ";
	$sql .= "select sum(round(dp_valor)) as total, round(dp_data/100) as data, 'U' as loja from duplicata_usebrilhe where round(dp_data/100) = '".$dd[2]."' and dp_boleto = '' and dp_lote <> '' group by data ";
	$sql .= " union ";
	$sql .= "select sum(round(dp_valor)) as total, round(dp_data/100) as data, 'S' as loja from duplicata_sensual where  round(dp_data/100) = '".$dd[2]."' and dp_boleto = '' and dp_lote <> '' group by data ";
	$sql .= " order by loja, data  ";
	}	
$rlt = db_query($sql);

$v1 = array();
$v2 = array();
$vv = array();
$sa = '';
while ($line = db_read($rlt))
	{
	$mes = $line['loja'];
	if (strlen($mes) == 0) { $xmes = $mes; }
	$nloja = $line['loja'];
	if ($nloja == 'S') { $xloja = 'Sensual'; }
	if ($nloja == 'J') { $xloja = 'Joias'; }
	if ($nloja == 'M') { $xloja = 'Modas'; }
	if ($nloja == 'O') { $xloja = 'Oculos'; }
	if ($nloja == 'U') { $xloja = 'UseBrilhe'; }
	if ($nloja == 'D') { $xloja = 'Juridico'; }	

	if ($mes != $xmes)
		{
		if (count($v1) > 0)
			{
			$sx .= '<TR><TD colspan="10">';
			$sx .= gr_barras($vv,$nome_loja,200);
			$sx .= '</TR>';
			$sx .= $sa;
			$sa = '';
			}
			$v1 = array();
			$v2 = array();
			$vv = array();
			$xmes = $mes;
		}
	
	$link = '<A HREF="faturamentos_2.php?dd0='.$dd[0].'&dd2='.$line['data'].'&dd1='.$dd[1].'">';	
	$sa .= '<TR '.coluna().'>';
	$sa .= '<TD>';
	$sa .= $link;
	$sa .= $xloja.' ';
	$mes = (substr($line['data'],6,2));
	$sa .= $mes;
	$sa .= '<TD>';
	$sa .= $line['loja'];
	$sa .= '<TD align="right">';
	$sa .= number_format($line['total'],2);
	$sa .= '</TR>';
	$sa .= '<TR><TD colspan="10" bgcolor="#c0c0c0" height="1"></TD></TR>';
	array_push($v1,$line['total']);
	array_push($v2,substr($line['data'],6,2));
	array_push($vv,array(intval('0'.$line['total']),substr($line['data'],6,2),''));	
	}
	
$sx .= '<TR><TD colspan="10">';
$sx .= gr_barras($vv,$nome_loja,200);
$sx .= '</TR>';	
?>
<center><font class="lt5">Faturamento <?=$mloja;?> <?=$eqi;?></font>
<TABLE width="<?=$tab_max;?>" class="lt2" align="center">
<?=$sx;?>
<?=$sa;?>
</TABLE>

<IMG SRC="<?=GoogleChat($v1,$v2);?>">

<? require($vinclude."foot.php");	?>
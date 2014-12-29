<?
$include = '../';
require($include."cab.php");
require($include."sisdoc_debug.php");
require($include."sisdoc_grafico.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");
require($include."google_chart.php");
require("../db_ecaixa.php");
$loja = $dd[0];
$eqi  = $dd[1];

$mes = date("m");
$ano = date("Y");

$mesi = "07";
$anoi = "2009";

if ($loja == 'J')
	{ $nloja = "02"; $mloja = "Semi-jóias"; }

if ($loja == 'M')
	{ $nloja = "03"; $mloja = "Intima"; }

if ($loja == 'O')
	{ $nloja = "04"; $mloja = "Óculos";}

if ($loja == 'U')
	{ $nloja = "05"; $mloja = "UseBrilhe"; }

if ($loja == 'S')
	{ $nloja = "01"; $mloja = "Boutique Sensual"; }

if ($loja == 'D')
	{ $nloja = "09"; $mloja = "Juridíco"; }
	
if ($loja == 'S')
	{ $nloja = "01"; $mloja = "Sensual";  }	
	
$ok=0;
$sql = '';
{
	if ($ok > 0)
		{ $sql .= " union "; }
	$sql  .= "select cx_data as data, '".$anoi.$mesi."' as data2, '".$loja."' as loja, ";
	$sql .= " sum((round(cx_valor*100)/100) * ct_soma) as total from caixa_".substr($dd[2],0,6)."_".$nloja." ";
	$sql .= " inner join caixa_tipo on ct_codigo = cx_tipo ";
	if ((strlen($eqi) > 0) and ($nloja != '01'))
		{
			$sql .= " inner join clientes on cx_cliente = cl_cliente ";
			$sql .= " where ct_recebido <> 0 and cl_clientep = '".$eqi."' ";
			$sql .= " and not (cx_tipo = 'DIN' and cx_valor < 0) ";			
		} else {
			$sql .= " where ct_recebido <> 0  ";
		}
	if (strlen($dd[2]) == 8)
		{
		$sql .= " and cx_data = '".$dd[2]."' ";
		}
	$sql .= " group by cx_data ";
	$sql .= " order by cx_data ";
	$mesi++;
	if ($mesi > 12) { $anoi++; $mesi = 1;}
	$mesi = strzero($mesi,2);
}	
$rlt = db_query($sql);

$v1 = array();
$v2 = array();
$vv = array();
while ($line = db_read($rlt))
	{
	$link = '<A HREF="receitas_2.php?dd0='.$dd[0].'&dd1='.$dd[1].'&dd2='.$line['data'].'">';	
	$sx .= '<TR '.coluna().'>';
	$sx .= '<TD>';
	$sx .= $link;
	$mes = substr($line['data'],6,2);
	$sx .= $mes;
	$sx .= '<TD>';
	$sx .= $line['loja'];
	$sx .= '<TD align="right">';
	$sx .= number_format($line['total'],2);
	$sx .= '</TR>';
	$sx .= '<TR><TD colspan="10" bgcolor="#c0c0c0" height="1"></TD></TR>';
	array_push($v1,$line['total']);
	array_push($v2,substr($line['data'],6,2));
	array_push($vv,array(intval($line['total']/100)/10,substr($line['data'],6,2)));
	$tot = $tot + $line['total'];
	}
?>
<font class="lt5">Receitas <?=$mloja;?> <?=$eqi;?></font>
<TABLE width="<?=$tab_max;?>" class="lt2" align="center">
<?=$sx;?>
</TABLE>
<?
	if (strlen($dd[2]) == 8)
		{
		$sql = "select * ";
		$sql .= "  from caixa_".substr($dd[2],0,6)."_".$nloja." ";
		$sql .= " inner join caixa_tipo on ct_codigo = cx_tipo ";
		$sql .= " inner join clientes on cx_cliente = cl_cliente ";
		$sql .= " where ct_recebido <> 0  ";
		$sql .= " and cx_data = '".$dd[2]."' ";
		$sql .= " and cl_clientep = '".$dd[1]."' ";
		$sql .= " and not (cx_tipo = 'DIN' and cx_valor < 0) ";
		$sql .= " order by cx_data ";
		$rlt = db_query($sql);
		
		$sn = '';
		$tot = 0;
		while ($line = db_read($rlt))
			{
			$sn .= '<TR '.coluna().'>';
			$sn .= '<TD align="center">';
			$sn .= stodbr($line['cx_data']);
			$sn .= '<TD align="left">';
			$sn .= $line['ct_descricao'];
			$sn .= '<TD align="right">';
			$sn .= number_format($line['cx_valor'],2);
			$sn .= '<TD align="center">';
			$sn .= $line['cx_cliente'];
			$sn .= '<TD align="center">';
			$sn .= $line['cl_clientep'];
			$sn .= '</TR>';
			$tot = $tot + $line['cx_valor'];
			}
		}
?>
<TABLE width="<?=$tab_max;?>" class="lt2" align="center">
<?=$sn;?>
<TR><TD colspan="5" align="right"><B><?=number_format($tot,2);?></B></TD></TR>
</TABLE>
<? require($vinclude."foot.php");	?>
<?
$include = '../';
require($include."cab.php");
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

$mesi = '01';
$anoi = date("Y")-1;


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
$limit = 0;
while (($ok >= 0) and ($limit < 20))
{
	$limit++;
	if ($ok > 0)
		{ $sql .= " union "; }
	$sql  .= "select '".$anoi.$mesi."' as data, '".$loja."' as loja, sum((round(cx_valor*100)/100) * ct_soma) as total from caixa_".$anoi.$mesi."_".$nloja." inner join caixa_tipo on ct_codigo = cx_tipo ";
	if ((strlen($eqi) > 0) )
		{
			$sql .= " inner join clientes on cx_cliente = cl_cliente ";
			$sql .= " where ct_recebido <> 0 and cl_clientep = '".$eqi."' ";
			$sql .= " and not (cx_tipo = 'DIN' and cx_valor < 0) ";			
		} else {
			$sql .= " where ct_recebido <> 0  ";
		}
	$mesi++;
	if ($mesi > 12) { $anoi++; $mesi = 1;}
	$mesi = strzero($mesi,2);
	$ok++;
	if (($anoi >= date("Y")) and ($mesi > date("m")))
		{
		$ok = -1;
		}
	if (intval($anoi) > date("Y")) { $ok = -1;}
}	
$sql .= " order by data desc ";
$rlt = db_query($sql);
$v1 = array();
$v2 = array();

while ($line = db_read($rlt))
	{
	$link = '<A HREF="receitas_2.php?dd0='.$dd[0].'&dd2='.$line['data'].'&dd1='.$dd[1].'">';	
	$sx .= '<TR '.coluna().'>';
	$sx .= '<TD>';
	$sx .= $link;
	$mes = nomemes(intval(substr($line['data'],4,2))).'/'.substr($line['data'],0,4);
	$sx .= $mes;
	$sx .= '<TD>';
	$sx .= $line['loja'];
	$sx .= '<TD align="right">';
	$sx .= number_format($line['total'],2);
	$sx .= '</TR>';
	$sx .= '<TR><TD colspan="10" bgcolor="#c0c0c0" height="1"></TD></TR>';
	array_push($v1,$line['total']);
	array_push($v2,troca($mes,'/','-'));
	}
?>
<font class="lt5">Receitas <?=$mloja;?> <?=$eqi;?></font>
<TABLE width="<?=$tab_max;?>" class="lt2" align="center">
<?=$sx;?>
</TABLE>

<IMG SRC="<?=GoogleBarLine($v1,$v2);?>">

<? require($vinclude."foot.php");	?>
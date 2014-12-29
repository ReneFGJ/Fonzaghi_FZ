<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/ger/fat.php','Receitas'));

$include = '../';
require($include."cab_novo.php");
require($include."sisdoc_debug.php");
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

$ok=0;
$sql = '';
$lojas = array("01","02","03","04","05","09");
while ($ok >= 0)
{
	if ($ok > 0)
		{ $sql .= " union "; }

$sql .= "select * from (";
for ($kt = 0;$kt < count($lojas);$kt++)
	{
	$nloja = $lojas[$kt];
	if ($kt > 0)
		{ $sql .= " union "; }
	$sql  .= "select '".$anoi.$mesi."' as data, '".$nloja."' as loja, sum((round(cx_valor*100)/100) * ct_soma) as total from caixa_".$anoi.$mesi."_".$nloja;;
//	$sql  .= "select '".$anoi.$mesi."' as data, '".$nloja."' as loja, sum(cx_valor) as total from caixa_".$anoi.$mesi."_".$nloja;
	$sql .= " inner join caixa_tipo on ct_codigo = cx_tipo ";
	$sql .= " where ct_recebido <> 0 and cx_status <> 'X'";
	}
	$sql .= ") as mes".$anoi.$mesi;
	if (strlen($eqi) > 0)
		{
			$sql .= " inner join cliente on cx_cliente = ce_cliente ";
			$sql .= " and ce_equipe = '".$eqi."' ";
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
$sql .= " order by data desc, total  ";	

$rlt = db_query($sql);

$v1 = array();
$v2 = array();
$xmes = '';
while ($line = db_read($rlt))
	{
	$mes = nomemes(intval(substr($line['data'],4,2))).'/'.substr($line['data'],0,4);
	if (strlen($mes) == 0) { $xmes = $mes; }
	$nloja = $line['loja'];
	if ($nloja == '01') { $xloja = 'Sensual'; }
	if ($nloja == '02') { $xloja = 'Joias'; }
	if ($nloja == '03') { $xloja = 'Modas'; }
	if ($nloja == '04') { $xloja = 'Oculos'; }
	if ($nloja == '05') { $xloja = 'UseBrilhe'; }
	if ($nloja == '09') { $xloja = 'Juridico'; }
	
	if ($mes != $xmes)
		{
		if (count($v1) > 0)
			{
			$sx .= '<TR><TD colspan="10">';
			$sx .= '<IMG SRC="'.GoogleChat($v1,$v2).'">';
			$sx .= '</TR>';
			}
			$v1 = array();
			$v2 = array();
			$xmes = $mes;
		}	
	$link = '<A HREF="receitas_detalhe.php?dd0='.$nloja.'&dd2='.$line['data'].'">';
	$sx .= '<TR '.coluna().'>';
	$sx .= '<TD>';
	$sx .= $link;
	$sx .= $xloja.' '.$mes;
	$sx .= '<TD>';
	$sx .= $line['loja'];
	$sx .= '<TD align="right">';
	$sx .= number_format($line['total'],2);
	$sx .= '</TR>';
	$sx .= '<TR><TD colspan="10" bgcolor="#c0c0c0" height="1"></TD></TR>';
	array_push($v1,$line['total']);
	array_push($v2,troca($xloja,' ','%20'));
	}
?>
<center><font class="lt5">Receitas <?=$mloja;?> <?=$eqi;?></font>
<TABLE width="<?=$tab_max;?>" class="lt2" align="center">
<?=$sx;?>
</TABLE>

<IMG SRC="<?=GoogleChat($v1,$v2);?>">

<? require($vinclude."foot.php");	?>
<?
/**
 * Relatório de faturamento por lojas
 * @author Rene F. Gabriel Junior
*/
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/ger/ger.php','Faturamento'));

$include = '../';
require($include."cab_novo.php");
require($include."sisdoc_debug.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");
require($include."google_chart.php");
require("../db_fghi_210.php");
$perfil->valid('#MST#GER#COJ#COM#COO#COS#GEG#MAR');
$loja = $dd[0];
$eqi  = $dd[1];

$mes = date("m");
$ano = date("Y");

$mesi = "07";
$anoi = "2009";

if ($loja == 'J')
	{ $nloja = "02"; $mloja = "Semi-jóias"; $nota = 'duplicata_joias'; }

if ($loja == 'M')
	{ $nloja = "03"; $mloja = "Intima"; $nota = 'duplicata_modas'; }

if ($loja == 'O')
	{ $nloja = "04"; $mloja = "Óculos";$nota = 'duplicata_oculos'; }

if ($loja == 'U')
	{ $nloja = "05"; $mloja = "UseBrilhe"; $nota = 'duplicata_usebrilhe'; }

if ($loja == 'S')
	{ $nloja = "01"; $mloja = "Boutique Sensual"; $nota = 'duplicata_sensual'; }

if ($loja == 'D')
	{ $nloja = "09"; $mloja = "Juridíco"; $nota = 'juridico_duplicata'; }
	
$ok=0;
$sql = '';

/////////////////////// Formula Nova
$sql = " select sum(round(dp_valor))/100 as total, loja, data from (";
if (strlen($nloja) == 0)
	{
		if ((strlen($eqi) > 0) )
			{
			$sqla .= " left join clientes on dp_cliente = cl_cliente ";
			$sqlb = " and (cl_clientep = '".$eqi."') ";
			}

		if (strlen($dd[3]) > 0)
			{
				$sql .= "select sum(round(dp_valor*100)) as dp_valor, round(dp_data/100) as data, 'A' as loja  from duplicata_joias ".$sqla." where dp_data > 20090101 and dp_boleto = '' and dp_status <> 'X' and dp_lote <> ''  ".$sqlb." group by loja, data ";
				$sql .= " union ";
				$sql .= "select sum(round(dp_valor*100)) as dp_valor, round(dp_data/100) as data, 'A' as loja from duplicata_modas ".$sqla." where dp_data > 20090101 and dp_boleto = '' and dp_status <> 'X'  and dp_lote <> '' ".$sqlb." group by loja, data" ;
				$sql .= " union ";
				$sql .= "select sum(round(dp_valor*100)) as dp_valor, round(dp_data/100) as data, 'A' as loja from duplicata_oculos ".$sqla." where dp_data > 20090101 and dp_boleto = '' and dp_status <> 'X'  and dp_lote <> '' ".$sqlb." group by loja, data ";
				$sql .= " union ";
				$sql .= "select sum(round(dp_valor*100)) as dp_valor, round(dp_data/100) as data, 'A' as loja from duplicata_usebrilhe ".$sqla." where dp_data > 20090101 and dp_boleto = '' and dp_status <> 'X'  and dp_lote <> '' ".$sqlb." group by loja, data ";
				$sql .= " union ";
				$sql .= "select sum(round(dp_valor*100)) as dp_valor, round(dp_data/100) as data, 'A' as loja from duplicata_sensual ".$sqla." where dp_data > 20090101 and dp_boleto = '' and dp_status <> 'X'  and dp_lote <> '' ".$sqlb." group by loja, data ";
			} else {
				$sql .= "select sum(round(dp_valor*100)) as dp_valor, round(dp_data/100) as data, 'J' as loja  from duplicata_joias ".$sqla." where dp_data > 20090101 and dp_boleto = '' and dp_status <> 'X' and dp_lote <> ''  ".$sqlb." group by loja, data ";
				$sql .= " union ";
				$sql .= "select sum(round(dp_valor*100)) as dp_valor, round(dp_data/100) as data, 'M' as loja from duplicata_modas ".$sqla." where dp_data > 20090101 and dp_boleto = '' and dp_status <> 'X'  and dp_lote <> '' ".$sqlb." group by loja, data" ;
				$sql .= " union ";
				$sql .= "select sum(round(dp_valor*100)) as dp_valor, round(dp_data/100) as data, 'O' as loja from duplicata_oculos ".$sqla." where dp_data > 20090101 and dp_boleto = '' and dp_status <> 'X'  and dp_lote <> '' ".$sqlb." group by loja, data ";
				$sql .= " union ";
				$sql .= "select sum(round(dp_valor*100)) as dp_valor, round(dp_data/100) as data, 'U' as loja from duplicata_usebrilhe ".$sqla." where dp_data > 20090101 and dp_boleto = '' and dp_status <> 'X'  and dp_lote <> '' ".$sqlb." group by loja, data ";
				$sql .= " union ";
				$sql .= "select sum(round(dp_valor*100)) as dp_valor, round(dp_data/100) as data, 'S' as loja from duplicata_sensual ".$sqla." where dp_data > 20090101 and dp_boleto = '' and dp_status <> 'X'  and dp_lote <> '' ".$sqlb." group by loja, data ";
			}
	} else {
		$sql .= "select round(dp_valor*100) as dp_valor, round(dp_data/100) as data, dp_cliente, substr('".$loja."',1,1) as loja  from ".$nota." ";
		$sqlx = '';
		if ((strlen($eqi) > 0) )
			{
			$sql .= " left join clientes on dp_cliente = cl_cliente ";
			$sqlx = " and (cl_clientep = '".$eqi."') ";
			}
		$sql .= " where (dp_data > 20090101 and dp_boleto = '' and dp_lote <> '' and dp_status <> 'X'  )  ".$sqlx;
	}
$sql .= ") as tabela ";
$sql .= " group by loja, data  ";
$sql .= " order by loja, data desc ";
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
require("../db_fghi_210.php");
$rlt = db_query($sql);
//echo $sql;
$v1 = array();
$v2 = array();
$xano = 2009;
$script ='';

$fid = array();
for ($r=2009;$r <= date("Y");$r++) { array_push($fid,$r); }

$nfid = array();
for ($r=1;$r <= 12;$r++) { array_push($nfid,nomemes_short($r)); }
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<?
$vlr = array();
for ($r=$xano;$r <= date("Y");$r++)
	{ array_push($vlr,array(0,0,0,0,0,0,0,0,0,0,0,0)); }
$xmes = "FIM";
$id=0;
while ($line = db_read($rlt))
	{
	$mes = nomemes(intval(substr($line['data'],4,2))).'/'.substr($line['data'],0,4);
	$ano = round(substr($line['data'],0,4));
	$nmes = round(substr($line['data'],4,2));
	
	if (strlen($mes) == 0) { $xmes = $mes; }
	$nloja = $line['loja'];
	if ($nloja == 'S') { $xloja = 'Sensual'; }
	if ($nloja == 'J') { $xloja = 'Joias'; }
	if ($nloja == 'M') { $xloja = 'Modas'; }
	if ($nloja == 'O') { $xloja = 'Oculos'; }
	if ($nloja == 'U') { $xloja = 'UseBrilhe'; }
	if ($nloja == 'D') { $xloja = 'Juridico'; }	

	if ($nloja != $xmes)
		{
		if (count($v1) > 0)
			{
			require('faturamentos_graficos.php');

			$sx .= '<TR><TD colspan="10">';
			$sx .= '>>>'.$nloja;
			$sx .= '</TR>';
			}
		$yloja = $xloja;
		/////////////////////////////////////////////////////////////////////////////////////////////
		
			$v1 = array();
			$v2 = array();
			$xmes = $nloja;
			$vlr = array();
			for ($r=$xano;$r <= date("Y");$r++)
				{ array_push($vlr,array(0,0,0,0,0,0,0,0,0,0,0,0)); }
		}
		$vlr[($ano-2009)][$nmes-1] = $line['total'];
//		$fid[0,$mes] = $line['total'];
	
	$link = '<A HREF="faturamentos_2.php?dd0=&dd2='.$line['data'].'&dd1='.$dd[1].'">';	
	$sx .= '<center><TR '.coluna().'>';
	$sx .= '<TD>';
	$sx .= $link;
	$sx .= $xloja.' ';
	$mes = nomemes(intval(substr($line['data'],4,2))).'/'.substr($line['data'],0,4);
	$sx .= $mes;
	$sx .= '<TD>';
	$sx .= $line['loja'];
	$sx .= '<TD align="right">';
	$sx .= number_format($line['total'],2);
	$sx .= '</TR>';
	$sx .= '<TR><TD colspan="10" bgcolor="#c0c0c0" height="1"></TD></TR>';
	array_push($v1,$line['total']);
	array_push($v2,$xloja);
	}
require('faturamentos_graficos.php');
?>
<font class="lt5">Faturamento <?=$mloja;?> <?=$eqi;?></font>
<TABLE width="<?=$tab_max;?>" class="lt2" align="center">
<?=$sx;?>
</TABLE>

<div id="visualization" style="width: 600px; height: 400px;"></div>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
  </head>
  <body style="font-family: Arial;border: 0 none;">

  </body>

<? require($vinclude."foot.php");	?>
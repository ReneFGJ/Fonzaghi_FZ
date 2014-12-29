<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/ger/fat.php','Receitas'));
array_push($breadcrumbs, array('/fonzaghi/ger/receitas_geral.php','Relatório'));


$include = '../';
require($include."cab_novo.php");
require($include."sisdoc_debug.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");
require($include."sisdoc_grafico.php");
require("../db_ecaixa.php");

global $max;
$max = 200;

$loja = $dd[0];
$eqi  = $dd[1];

$mes = date("m");
$ano = date("Y");

$ok=0;
$sql = '';
$lojas = array("01","02","03","04","05","09");
$lojas = array($dd[0]);
$sql .= "select * from (";
//for ($kt = 0;$kt < count($lojas);$kt++)
//	{
	$nloja = $dd[0];
	if ($kt > 0)
		{ $sql .= " union "; }
	$sql  .= "select '".$dd[2]."' as data, '".$nloja."' as loja, cx_data, sum((round(cx_valor*100)/100) * ct_soma) as total from caixa_".$dd[2]."_".$dd[0];
	$sql .= " inner join caixa_tipo on ct_codigo = cx_tipo ";
	$sql .= " where ct_recebido <> 0 ";
	$sql .= " group by cx_data  ";	
//	}
	$sql .= ") as mes".$dd[2];
	if (strlen($eqi) > 0)
		{
			$sql .= " inner join cliente on cx_cliente = ce_cliente ";
			$sql .= " and ce_equipe = '".$eqi."' ";
		}
$sql .= " order by cx_data , total  ";	
$rlt = db_query($sql);

$v1 = array();
$v2 = array();
$vv = array();
$xmes = '';

global $max;
$max = 100;

while ($line = db_read($rlt))
	{
	$mes = $line['loja'];
//	if (strlen($mes) == 0) { $xmes = $mes; }
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
			$sx .= substr($line['cx_data'],8,2);
			$sx .= gr_barras($vv,$nome_loja,200);
//			$sx .= '<IMG SRC="'.gr_barras($v1,$v2.'1').'">';
			$sx .= '</TR>';
			}
			$v1 = array();
			$v2 = array();
			$vv = array();
			$xmes = $mes;
		}	
	$link = '<A HREF="receitas_detalhe.php?dd0='.$nloja.'&dd1='.$mes.'">';
	$sx .= '<TR '.coluna().'>';
	$sx .= '<TD>';
	$sx .= substr($line['cx_data'],6,2);
	$sx .= '<TD>';
//	$sx .= $link;
	$sx .= $xloja.' '.$mes;
	$sx .= '<TD>';
	$sx .= $line['loja'];
	$sx .= '<TD align="right">';
	$sx .= number_format($line['total'],2);
	$sx .= '</TR>';
	$sx .= '<TR><TD colspan="10" bgcolor="#c0c0c0" height="1"></TD></TR>';
	array_push($v1,intval('0'.$line['total']));
	array_push($v2,troca(substr($line['cx_data'],6,2),' ','%20'));
	array_push($vv,array(intval('0'.$line['total']),troca(substr($line['cx_data'],6,2),' ','%20'),''));
	$nome_loja = $xloja;
	}
?>
<center><font class="lt5">Receitas <?=$mloja;?> <?=$eqi;?></font>
<TABLE width="<?=$tab_max;?>" class="lt2" align="center">
<?=$sx;?>
</TABLE>

<? echo gr_barras($vv,$nome_loja,200); ?>

<? require($vinclude."foot.php");	?>
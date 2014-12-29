<?
/**
 * Relatório de faturamento por lojas
 * @author Rene F. Gabriel Junior
*/
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/ger.php','ger'));
array_push($breadcrumbs, array('/fonzaghi/ger/faturamentos.php','Faturamento por lojas'));

$include = '../';
require($include."cab.php");
require($include."sisdoc_debug.php");
require($include."sisdoc_data.php");
require("../db_ecaixa.php");

$sql = 'select * from (
select ccard_cliente, sum(ccard_valor) as valor, max(ccard_data) as data 
from credito_outros
GROUP by ccard_cliente ) as tabela
where ((valor <= 0.10) and (data < '.dateadd('m',-1,date("Ymd")).')) or (data < '.DateAdd('m',-5,date("Ymd")).') ';
$rlt = db_query($sql);

$wh = '';
while ($line = db_read($rlt))
	{
	if (strlen($wh) > 0) { $wh .= ' or '; }
	$wh .= " ccard_cliente = '".$line['ccard_cliente']."' ";
	}
if (strlen($wh) > 0)
	{
	$sql = "delete from credito_outros where ".$wh;
	$rlt = db_query($sql);
	}
echo '<table width="'.$tab_max.'">';
echo '<TR><TD>Limpado clientes com valores negativos </TD><TD><font color="green">OK</font></TD></TR>';

///////////////////////////////////////////////////////////////////////////////////////////////////////
$sql = "update credito_outros set ccard_valor = round(ccard_valor*100)/100 ";
$rlt = db_query($sql);
echo '<TR><TD>Arredondando valores</TD><TD><font color="green">OK</font></TD></TR>';


////////////////////////////////////////////////////////////////////////////// SALDOS
$sql = "select * from credito_outros ";
$rlt = db_query($sql);
echo '<TR><TD>Arredondando valores</TD><TD><font color="green">OK</font></TD></TR>';


echo '</table>';


?>
<?
$include = '../';
$nocab=1;
require ("../cab_novo.php");
require ($include . "sisdoc_lojas.php");
require ($include . "sisdoc_data.php");
require ('../_class/_class_bi.php');
$bi = new bi;

header("Content-type: application/vnd.ms-excel; name='excel' ");
header("Content-Disposition: filename=analise_vendas.xls");
header("Pragma: no-cache");
header("Expires: 0");

$dt1 = $dd[1];
$dt2 = $dd[2];
$dtx1 = dataExt($dt1,'br');
$dtx2 = dataExt($dt2,'br');
$ljx = $dd[0];
$cons = $dd[3];
setlj2();

require ('../'.$setlj[3][$ljx]);

echo $bi -> analisar_consultoras_por_periodo($dt1, $dt2, $ljx,$cons);
 
?>
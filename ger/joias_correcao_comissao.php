<?
$include = '../';
require("../cab.php");
require($include.'sisdoc_colunas.php');
require("../db_fghi_206_joias.php");
/** 30% **/
$sql = "select pe_vref, pe_mostruario, * from kits_consignado
inner join produto_consignado on pe_mostruario = kh_kits
where kh_dif = 1 and kh_status = 'A'
and kh_comissao = 30 order by pe_mostruario";

$rlt = db_query($sql);
while ($line = db_read($rlt))
{
	$sql = "
update produto_consignado 
	set pe_vref = 5.2 where pe_mostruario = '".$line['pe_mostruario']."' 
	and (pe_tipo <> '5' and pe_tipo <> '4' and pe_tipo <> '0');
update produto_consignado 
	set pe_vref = 4.16 where pe_mostruario = '".$line['pe_mostruario']."' 
	and (pe_tipo = '5' or pe_tipo = '4' or pe_tipo = '0');
	";
	$zrlt = db_query($sql);
}
/** 40% **/
$sql = "select pe_vref, pe_mostruario, * from kits_consignado
inner join produto_consignado on pe_mostruario = kh_kits
where kh_dif = 1 and kh_status = 'A'
and kh_comissao = 40 order by pe_mostruario";

$rlt = db_query($sql);
while ($line = db_read($rlt))
{
	$sql = "
update produto_consignado 
	set pe_vref = 6.6 where pe_mostruario = '".$line['pe_mostruario']."' 
	and (pe_tipo <> '5' and pe_tipo <> '4' and pe_tipo <> '0');
update produto_consignado 
	set pe_vref = 5.28 where pe_mostruario = '".$line['pe_mostruario']."' 
	and (pe_tipo = '5' or pe_tipo = '4' or pe_tipo = '0');
	";
	$zrlt = db_query($sql);
}
/** 40% **/
$sql = "select pe_vref, pe_mostruario, * from kits_consignado
inner join produto_consignado on pe_mostruario = kh_kits
where kh_dif = 1 and kh_status = 'A'
and kh_comissao = 50 order by pe_mostruario";

$rlt = db_query($sql);
while ($line = db_read($rlt))
{
	$sql = "
update produto_consignado 
	set pe_vref = 8 where pe_mostruario = '".$line['pe_mostruario']."' 
	and (pe_tipo <> '5' and pe_tipo <> '4' and pe_tipo <> '0');
update produto_consignado 
	set pe_vref = 6.4 where pe_mostruario = '".$line['pe_mostruario']."' 
	and (pe_tipo = '5' or pe_tipo = '4' or pe_tipo = '0');
	";
	$zrlt = db_query($sql);
}
?>
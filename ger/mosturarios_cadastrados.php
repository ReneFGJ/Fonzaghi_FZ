<?
$include = '../';
require("../cab_novo.php");
global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_data.php');

if (strlen($dd[1]) == 0) { $dd[1] = date("d/m/Y"); }
if (strlen($dd[2]) == 0) { $dd[2] = date("d/m/Y"); }

	$cp = array();
	$tabela = '';
	array_push($cp,array('$H8','','',False,True));
	array_push($cp,array('$D8','','Data Inicial',False,True));
	array_push($cp,array('$D8','','Data final',False,True));
	$tabela = $cl->tabela;
	
	$http_edit = 'mosturarios_cadastrados.php';
	$http_redirect = '';
	$tit = 'Período';

	/** Comandos de Edição */
	echo '<h1>Consulta de Cadastro de Mostruários - JAudit</h1>';
	echo '<CENTER><font class=lt5>'.$tit.'</font></CENTER>';
	echo '<CENTER><font class=lt3>'.$dd[1].' ate '.$dd[2].'</font></CENTER>';
	?><center><TABLE width="<?=$tab_max;?>" align="center" bgcolor="<?=$tab_color;?>"><TR><TD><?
	editar();
	?></TD></TR></TABLE><?		
	
if ($saved > 0)
{
	$data1 = substr(brtos($dd[1]),0,6).'01';
	$data2 = substr(brtos($dd[2]),0,6).'99';

	$data3 = brtos($dd[1]);
	$data4 = brtos($dd[2]);
	

require("../db_fghi_206_joias.php");

$sql = "
select pe_log_fornece, count(*) as total from (
select substr(pe_mostruario,1,1), 1, pe_mostruario, pe_log_fornece, min(pe_data_cadastro) as data from produto_consignado 
where (pe_status = 'A' or pe_status = 'B')
and pe_data_cadastro >= ".$data1." and pe_data_cadastro <= ".$data2."
and substr(pe_mostruario,1,1) <> 'X'
group by pe_mostruario, pe_log_fornece
) as tabela
group by pe_log_fornece
order by pe_log_fornece
";

$rlt = db_query($sql);

while ($line = db_read($rlt))
	{
		$sx .= '<TR '.coluna().'>';
		$sx .= '<TD align="center">'.$line['total'];
		$sx .= '<TD align="center">'.$line['pe_log_fornece'];
	}

/** DIARIO **/
$sql = "
select pe_log_fornece, count(*) as total from (
select substr(pe_mostruario,1,1), 1, pe_mostruario, pe_log_fornece, min(pe_data_cadastro) as data from produto_consignado 
where (pe_status = 'A' or pe_status = 'B')
and pe_data_cadastro >= $data3 and pe_data_cadastro <= $data4
and substr(pe_mostruario,1,1) <> 'X'
group by pe_mostruario, pe_log_fornece
) as tabela
group by pe_log_fornece
order by pe_log_fornece
";

$rlt = db_query($sql);

while ($line = db_read($rlt))
	{
		$sa .= '<TR '.coluna().'>';
		$sa .= '<TD align="center">'.$line['total'];
		$sa .= '<TD align="center">'.$line['pe_log_fornece'];
	}
	
echo '<table width="600"><TR valign="top">';
	echo '<TD width="50%">';
	echo '<table width="100%">';
	echo '<TR><TD colspan=2 align="center">Acumulado do Mês '.substr($data1,4,2).'/'.substr($data1,0,4);	
	echo '<TR><TH>Total<TH>Login';
	echo $sx;
	echo '</table>';

	echo '<TD width="50%">';
	echo '<table width="100%">';
	echo '<TR><TD colspan=2 align="center">Acumulado do Dia';
	echo '<TR><TH>Total<TH>Login';
	echo $sa;
	echo '</table>';

echo '</table>';

}
?>
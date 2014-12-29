<?
$breadcrumbs=array();
array_push($breadcrumbs, array('index.php','Home'));

$include = '../';
require("../cab_novo.php");
require($include."sisdoc_windows.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_form2.php");
require($include."sisdoc_data.php");
require($include."sisdoc_debug.php");
require($include."cp2_gravar.php");
require("../db_caixa_central.php");

echo '<h1>Notas Fiscais de Entrada</h1><center>';

if ($dd[1]==''){
	$cp = array();
		array_push($cp,array('$HS7','','Notas de Entradas',false,false,''));
		array_push($cp,array('$D8','','Data do inicial',True,True,''));
		array_push($cp,array('$D8','','Data do final',True,True,''));
	
	echo '<TABLE align="center" width="'.$tab_max.'">';
	echo '<TR><TD>';
	editar();
	echo '</TABLE>';
	echo '<TR><TD align="center" class="lt1">Passo 1 de 2';

	require("../foot.php");	
} else {
	$sql = "select * from pedido ";
	$sql .= "left join empresa on ped_fisico = e_codigo ";
	$sql .= " where ped_nf_conf_dt >= '".brtos($dd[1])."' and ped_nf_conf_dt <= '".brtos($dd[2])."'";
	$sql .= " order by e_codigo, ped_nomefornecedor, ped_chegada desc ";
	$rlt = db_query($sql);
	$tot=0;
	$it =0;
	$ep = -1;
	$xa = 'X';
	while ($line = db_read($rlt))
		{
		if ($xa != $line['e_codigo'])
			{
			$xa = $line['e_codigo'];
			$s .= '<TR><TD colspan="5" class="lt3">>>> <B><I>'.$line['e_nome'].'</TD></TR>';
			}
		if ($ep != $line['ped_fisico'])
			{
			$ep != $line['ped_fisico'];
			$s .= '<TR><TD colspan="8"><HD></TR>';
			}
		$it++;
		$link = '<A HREF="javascript:newxy2('.chr(39).'http://10.1.1.220/fonzaghi/pedidos/pedido.php?dd0='.$line['id_ped'].chr(39).',700,600);">';
		$tot = $tot + $line['ped_nf_vlr'];
		$s .= '<TR '.coluna().'>';
		$s .= '<TD>'.$link.$line['ped_nrped'].'</TD>';
		$s .= '<TD>'.$line['ped_nomefornecedor'].'</TD>';
		$s .= '<TD align="right">'.number_format($line['ped_nf_vlr'],2).'</TD>';
		$s .= '<TD>&nbsp;'.$line['ped_nrnf'].'&nbsp;</TD>';
		$s .= '<TD>&nbsp;'.$line['ped_fisico'].'&nbsp;</TD>';
		$s .= '<TD>'.$line['ped_empresa'].'</TD>';
		$s .= '<TD>'.stodbr($line['ped_nf_data']).'</TD>';
		$s .= '<TD>'.stodbr($line['ped_nf_conf_dt']).'</TD>';
		$s .= '<TD>'.$line['ped_status'].'</TD>';
		$s .= '</TR>';
		}
	?>
	<h2>de <?=$dd[1];?> até <?=$dd[2];?></h2>
	<table width="<?=$tab_max;?>" class="lt1">
	<TR>
		<TH class="tabelaTH">Fornecedor</TH>
		<TH class="tabelaTH">Valor NF</TH>
		<TH class="tabelaTH">Nr. NF</TH>
		<TH class="tabelaTH">Físico</TH>
		<TH class="tabelaTH">Empres.</TH>
		<TH class="tabelaTH">Data NF</TH>
		<TH class="tabelaTH">Data Conf.</TH>
		<TH class="tabelaTH">St</TH>
	</TR>
		<?=$s;?>
	<TR><TD colspan="5">Total de <B><?=$it;?></B> notas, totalizando <B><?=number_format($tot,2);?></B></TD></TD></TR>
	</table>
	<?
}

require("../foot.php");	
?>
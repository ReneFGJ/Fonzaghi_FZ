<?
$include = '../';
require("../cab_novo.php");
require($include.'sisdoc_debug.php');
global $acao,$dd,$cp,$tabela;
require($include.'cp2_gravar.php');
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_form2.php');
require($include.'sisdoc_data.php');


	$cp = array();
	$tabela = '';
	array_push($cp,array('$H8','','',False,True));
	array_push($cp,array('$I8','','N�mero Inicial',True,True));
	array_push($cp,array('$I8','','N�mero Final',True,True));
	array_push($cp,array('$C8','','N�o fornecidos',False,True));
	array_push($cp,array('$C8','','Cadastrados',False,True));
	$tabela = $cl->tabela;
	
	$http_edit = 'mosturarios_faudit.php';
	$http_redirect = '';
	$tit = '';
	echo '<h1>Invent�rio de Mostru�rios - FAudit</h1>';

	/** Comandos de Edi��o */
	echo '<CENTER><font class=lt5>Mostru�rios do n�mero </font></CENTER>';
	echo '<CENTER><font class=lt3>'.$dd[1].' at� '.$dd[2].'</font></CENTER>';
	?><center><TABLE width="<?=$tab_max;?>" align="center" bgcolor="<?=$tab_color;?>"><TR><TD><?
	editar();
	?></TD></TR></TABLE><?		
	
if ($saved > 0)
{

require("../db_fghi_206_joias.php");

$sql = "select * from kits_consignado 
		where (kh_status = '@' or kh_status = 'A')
		order by kh_kits
		";
		
if ($dd[4]=='1')
	{
	$sql = "select * from kits_consignado 
		where (kh_status = '@')
		order by kh_kits
		";	
	}		
$rlt = db_query($sql);
$ini = round($dd[1]);
$fim = round($dd[2]);
$pos = $ini;
echo '<table width="'.$tab_max.'" class="lt1">';
echo '<TR><TH>Mostru�rio<TH>Status';
$sta = array('@'=>'Cadastrado','A'=>'Fornecido para o cliente');
$tot = 0;
while (($line = db_read($rlt)) and ($pos <= $fim))
	{
	$mos = round($line['kh_kits']);
	if (($mos >= $ini) and ($mos <= $fim))
	{
	for ($r=$pos; $r < $mos;$r++)
		{
			if ($dd[4]=='')
			{
				echo '<TR '.coluna().'>';
				echo '<TD colspan="1" width="50" align="center">';
				echo strzero($pos,5);
			
				echo '<TD colspan="5" width="95%">';
				echo '== Mostru�rio dispon�vel ==';
			}
			$pos++;
		}
	if (($mos >= $ini) and ($mos <= $fim))
		{
			if ($dd[3]=='')
			{
				echo '<TR '.coluna().'>';
				echo '<TD width="50" align="center">';
				echo strzero($pos,5);
				echo '<TD width="95%">';
				echo $sta[$line['kh_status']];
				echo ' ';
				echo $line['kh_cliente'];
				$tot++;
			}
		}
	$pos++;
	}
	}
echo '<TR><TD colspan=2>Total de '.$tot.' mostru�rios';
echo '</table>';

}
?>
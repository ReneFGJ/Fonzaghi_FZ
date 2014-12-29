<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/impressora.php','Impressoras'));
array_push($breadcrumbs, array('/fonzaghi/ger/ed_printers.php','Cadastrar/Alterar impressora'));

$include = '../';
require($include."cab.php");
require($include."sisdoc_menus.php");

//$include = '../';
//require("../db.php");
require($include."letras.css");
require($include."sisdoc_windows.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_form2.php");
require($include."sisdoc_data.php");
require($include."sisdoc_debug.php");
require($include."cp2_gravar.php");
require($include."biblioteca.php");
require("../db_206_printers.php");

global $tab_max;

if (strlen($dd[0])==0){
	echo msg_erro("O Código da impressora não setado.");
	require("../foot.php");	
	exit;
}

$sql = "SELECT id_pr, pr_nome, pr_fila, pr_ip, pr_install, pr_obs, pr_ativa,  ";
$sql .= " pr_counter, pr_codigo, pr_ultimacoleta, pr_tipo ";
$sql .= " FROM printers ";
$sql .= " where pr_codigo = '".$dd[0]."' ";

echo '<table border="0" class="1_naoLinhaVertical" width='.$tab_max.' align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">';

echo '<tr>';
echo '<TD colspan="6" class="lt5" align="center">Registros</td>';
echo '</tr>';

echo '<TH class="1_th">Data</TH>';
echo '<TH class="1_th">Código</TH>';
echo '<TH class="1_th">Nome</TH>';
echo '<TH class="1_th">http</TH>';
echo '<TH class="1_th">Páginas</TH>';
echo '<TH class="1_th">Toner</TH>';
echo '</tr>';

$sql="SELECT pc_data, pc_codigo, pr_nome, pr_counter, pc_pages, pc_tonner
  FROM printers_count
  left join printers on pr_codigo = pc_codigo
  where pc_codigo = '".$dd[0]."'
  order by pc_data, pc_codigo";

$rlt = db_query($sql);

$reg=0;
while ($line=db_read($rlt)){
	echo '<tr '.coluna().'>';

	echo '<td class="1_td" align="left">';
	echo stodbr($line['pc_data']);
	echo '</td>';

	echo '<td class="1_td" align="center">';
	echo $line['pc_codigo'];
	echo '</td>';

	echo '<td class="1_td" align="left">';
	echo $line['pr_nome'];
	echo '</td>';

	echo '<td class="1_td" align="left">';
	echo $line['pr_counter'];
	echo '</td>';

	echo '<td class="1_td" align="center">';
	echo $line['pc_pages'];
	echo '</td>';

	echo '<td class="1_td" align="center">';
	echo $line['pc_tonner'];
	echo '</td>';

	echo '</tr>';
	$reg++;
}

echo '<tr>';
if ($reg == 1)
	echo '<td colspan="6" class="rodapetotal">'.$reg.' ítem</td>';
else
	echo '<td colspan="6" class="rodapetotal">'.$reg.' ítens</td>';
echo '</tr>';

echo '</table>';

require("../foot.php");	
?>
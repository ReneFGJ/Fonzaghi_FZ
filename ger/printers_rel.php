<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/impressora.php','Impressoras'));
array_push($breadcrumbs, array('/fonzaghi/ger/printers_rel.php','Relatório geral: impressoras e páginas impressas'));

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

echo '<CENTER><font class="lt5">Impressoras e páginas impressas</font></CENTER>';
if ($dd[0]==''){

	$dd[0]=calculaDataMenor(1);
	$dd[1]=calculaDataMaior(1);

	$cp = array();
	array_push($cp,array('$D8','','De',True,True,''));
	array_push($cp,array('$D8','','Até',True,True,''));

	echo '<TABLE align="center" width="'.$tab_max.'">';
	echo '<TR><TD>';
	editar();
	echo '</TABLE>';
	
	require("../foot.php");	
	exit;
}
echo '<CENTER><font class="lt1">No período de: '.$dd[0].' até '.$dd[1].'</font></CENTER>';
echo '<CENTER><font class="lt1">Ordenação: <b><i>Código</i></b> > <b><i>Data</i></b> (Decrescente)</font></CENTER>';
echo '<br>';

$sql="SELECT pc_data, pc_codigo, pr_nome, pr_counter, pc_pages, pc_tonner
  FROM printers_count
  left join printers on pr_codigo = pc_codigo
  where pc_data >= ".brtos($dd[0])." and pc_data <= ".brtos($dd[1])."
  order by pc_codigo, pc_data desc";

$rlt = db_query($sql);

$reg=0;
echo '<table border="0" class="1_naoLinhaVertical" width='.$tab_max.' align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">';
$codigo='';
while ($line=db_read($rlt)){

	if ($codigo != $line['pc_codigo']){
		if ($reg > 0){
			echo '<tr>';

			if ($reg==1)
				echo '<td colspan="3" class="rodapetotal">'.$reg.' ítem</td>';
			else
				echo '<td colspan="3" class="rodapetotal">'.$reg.' ítens</td>';
				
			echo '</tr>';
			echo '<tr>';
			echo '<td colspan="3"><br></td>';
			echo '</tr>';
			
		}

		echo '<tr>';
		echo '<td class="lt1" colspan="3"><b><i>'.$line['pc_codigo'].' '.$line['pr_nome'].'</i></b></td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<TH class="1_th">Data</TH>';
		echo '<TH class="1_th">Páginas</TH>';
		echo '<TH class="1_th">Toner</TH>';
		echo '</tr>';
		$codigo=$line['pc_codigo'];
		$reg=0;
	}

	echo '<tr '.coluna().'>';

	echo '<td class="1_td" align="center">';
	echo stodbr($line['pc_data']);
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
if ($reg==1)
	echo '<td colspan="3" class="rodapetotal">'.$reg.' ítem</td>';
else
	echo '<td colspan="3" class="rodapetotal">'.$reg.' ítens</td>';
echo '</tr>';

echo '</table>';

require("../foot.php");	
?>
<?
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/ger/impressora.php','Impressoras'));
array_push($breadcrumbs, array('/fonzaghi/ger/printers_grafico.php','Gráfico da impressão mensal'));

$include = '../';
require($include."cab_novo.php");
require($include."sisdoc_menus.php");
require($include."sisdoc_windows.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_form2.php");
require($include."sisdoc_data.php");
require($include."sisdoc_debug.php");
require($include."cp2_gravar.php");
require($include."biblioteca.php");
require($include."letras.css");
require("../db_206_printers.php");

echo '<CENTER><font class="lt5">Gráfico da impressão mensal</font></CENTER>';
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
echo '<br>';

//
$sql="SELECT pc_codigo, pc_data, min(pc_pages) as pc_pages_min, max(pc_pages) as pc_pages_max
			from (SELECT pc_codigo, SUBSTR(CAST(pc_data AS text),0,7) as pc_data, pc_pages
			      FROM (SELECT pc_codigo, pc_data, pc_pages
				    FROM printers_count
					where pc_data >= ".brtos($dd[0])." and pc_data <= ".brtos($dd[1])."
					order by pc_codigo, pc_data
			      ) as t1  
			      order by pc_codigo, pc_data
			     ) as t2
			left join printers on pr_codigo = pc_codigo
			group by pc_data, pc_codigo
			order by pc_codigo, pc_data";

$rlt_geral = db_query($sql);

if (pg_num_rows($rlt_geral) == 0){
	echo msg_erro("Não há registro neste período!");
	require("../foot.php");	
	exit;
}

$tb=array();

$pages_max=0;
$codigo='';
$data=0;
$contador=0;

$line=db_read($rlt_geral);

$pages_max=$line['pc_pages_max'];
$pages_min=$line['pc_pages_min'];
$codigo=$line['pc_codigo'];
$data=$line['pc_data'];

for ($i=0; $i < pg_num_rows($rlt_geral); $i++){
	if ($contador==0){
		array_push($tb, array($codigo, $data, $pages_min, $pages_max, 0));
	}
	else{
		if ($codigo==$line['pc_codigo']){
			array_push($tb, array($line['pc_codigo'], $line['pc_data'], $pages_max, $line['pc_pages_max']));
			$pages_max=$line['pc_pages_max'];
			$pages_min=$line['pc_pages_min'];
			$codigo=$line['pc_codigo'];
			$data=$line['pc_data'];
		}
		else{
			$contador=0;
			$pages_max=$line['pc_pages_max'];
			$pages_min=$line['pc_pages_min'];
			$codigo=$line['pc_codigo'];
			$data=$line['pc_data'];
			array_push($tb, array($codigo, $data, $pages_min, $pages_max, 0));
		}
	}
	$line=db_read($rlt_geral);
	$contador++;
}

$maiorConsumo=0;
$codigo='';
$dataConsumo=0;
for($i=0;$i<count($tb); $i++){
	$tb[$i][4]=$tb[$i][3]-$tb[$i][2];
	//echo '<br>['.$i.'] '.$tb[$i][0].'-'.$tb[$i][1].'-'.$tb[$i][2].'-'.$tb[$i][3].'-'.$tb[$i][4];
	if ($tb[$i][4] > $maiorConsumo){
		$maiorConsumo=$tb[$i][4];
		$topo_grafico=$tb[$i][4];
		$codigo=$tb[$i][0];
		$dataConsumo=$tb[$i][1];
	}
}

//echo '<br>----------------------------';

$tbOrdenada=ordenaArray($tb, 1);
$tbGeral=array();
$data=$tbOrdenada[0][1];
$soma=0;
for($i=0;$i<=count($tbOrdenada); $i++){
	//echo '<br>['.$i.'] '.$tbOrdenada[$i][0].'-'.$tbOrdenada[$i][1].'-'.$tbOrdenada[$i][2].'-'.$tbOrdenada[$i][3].'-'.$tbOrdenada[$i][4];
	if ($data==$tbOrdenada[$i][1]){
		$soma+=$tbOrdenada[$i][4];
	}
	else{
		array_push($tbGeral, array($data, $soma));
		$soma=$tbOrdenada[$i][4];
		$data=$tbOrdenada[$i][1];
	}
}

//echo '<br>----------------------------';
//echo '<br> count='.count($tbGeral);


////////////////////////////////////////////////////////////////////
$jc='';
for($i=0;$i<count($tbGeral); $i++){
	$jc .= "data.setValue(".$i.", 0, '".mes_legenda(substr($tbGeral[$i][0], 4, 2))."');".chr(13).chr(10);
	$jc .= "data.setValue(".$i.", 1, ".$tbGeral[$i][1].");".chr(13).chr(10);
}

//echo '<br>i: '.$i;
//echo '<br>jc: '.$jc;

?>
	<head>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Ano');
        data.addColumn('number', 'Páginas impressas');
        data.addRows(<?=($i+2);?>);
		<?=$jc;?>
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 700, height: 350, title: 'Fonzaghi - Consumo mensal das impressoras'});
      }
    </script>
	</head>
	
  <body>
    <div id="chart_div"></div>
  </body>

<?

//////////////////////////////////////////////////////////////


$topo_grafico=0;
$colunas=0;
for($i=0;$i<count($tbGeral); $i++){
	//echo '<br>['.$i.'] '.$tbGeral[$i][0].'-'.$tbGeral[$i][1];
	if ($tbGeral[$i][1] > $topo_grafico)
		$topo_grafico = $tbGeral[$i][1];
		
	$dados .= $tbGeral[$i][1].',';
	$label_mes .=mes_legenda(substr($tbGeral[$i][0], 4, 2)).'|';
	//echo '<br> '.$label_mes;
	$tb_titulo .= '<th class="1_th">'.mes_legenda(substr($tbGeral[$i][0], 4, 2)).'</th>'; 
	$tb_dados .= '<td clas="1_td" align="center"><b><font color="#0000ff">'.$tbGeral[$i][1].'</font></b></td>';
	$colunas++;
}
$dados=substr($dados, 0, strlen($dados)-1); // retirando o caracter ,
$label_mes=substr($label_mes, 0, strlen($label_mes)-1); // retirando o caracter ,

echo '<TABLE border="0" align="center" width="'.$tab_max.'">';
echo '<tr>';
echo '<td>';
//visualizar_grafico("Consumo de todas as impressoras", $dados, $label_mes, $topo_grafico);
echo '</td>';
echo '</tr>';


echo '<tr>';
echo '<td>';
echo '<CENTER><font class="lt3">Dados do gráfico</font></CENTER>';
echo '<table border="0" class="1_naoLinhaVertical" width='.$tab_max.' align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">';
echo '<tr>';
echo $tb_titulo;
echo '</tr>';

echo '<tr '.coluna().'>';
echo $tb_dados;
echo '</tr>';

echo '<tr><td class="total" colspan="'.$colunas.'" >&nbsp;</td></tr>';

echo '</table>';
echo '</td>';
echo '</tr>';

$sql="SELECT * FROM printers where pr_codigo='".$codigo."'";
$rlt=db_query($sql);
$line=db_read($rlt);
echo '<tr>';
echo '<td class="lt3" color=#0080ff>';
echo '<br><p><b>Observação</b>: Impressora com o maior consumo: <strong>'.trim($line['pr_codigo']).' '.trim($line['pr_nome']).'('.trim($line['pr_fila']).')</strong> em <strong>'.mes_legenda(substr($dataConsumo, 4, 2)).'</strong> com <strong>'.$maiorConsumo.'</strong> páginas impressas.</p>';
echo '</td>';
echo '</tr>';

echo '</table>';
require("../foot.php");	


//-FUNÇÕES AUXILIARES--------------------------------------------------------------------

function ordenaArray($tb, $idx){
	//$aux=array();
	$aux=$tb;
	//print_r($aux);
	//echo '<br>aux----------------------------';
	for($i=0;$i<count($tb);$i++){
		//$next=0;
		//echo '<br>A['.$i.'] '.$aux[$i][0].'-'.$aux[$i][1].'-'.$aux[$i][2].'-'.$aux[$i][3].'-'.$aux[$i][4];
		for($j=0,$next=1; $j<count($tb);$j++,$next++){;
			//$next=$j+1;
			if ($next == count($tb)){
				$next=(count($tb)-1);
			}
			if ($aux[$j][$idx] > $aux[$next][$idx]){
				
				$c0=$aux[$next][0];
				$c1=$aux[$next][1];
				$c2=$aux[$next][2];
				$c3=$aux[$next][3];
				$c4=$aux[$next][4];
				
				//echo '<br>v['.$j.'] '.$aux[$j][0].'-'.$aux[$j][1].'-'.$aux[$j][2].'-'.$aux[$j][3].'-'.$aux[$j][4];
				$aux[$next][0]=$aux[$j][0];
				$aux[$next][1]=$aux[$j][1];
				$aux[$next][2]=$aux[$j][2];
				$aux[$next][3]=$aux[$j][3];
				$aux[$next][4]=$aux[$j][4];
				
				//echo '<br>^['.$j.'] '.$c0.'-'.$c1.'-'.$c2.'-'.$c3.'-'.$c4;
				$aux[$j][0]=$c0;
				$aux[$j][1]=$c1;
				$aux[$j][2]=$c2;
				$aux[$j][3]=$c3;
				$aux[$j][4]=$c4;
				//echo '<br>';
			}
		}
	}
	return $aux;
}

function visualizar_grafico($_titulo, $_dados, $_label_mes, $topo){
	echo "<tr>";
	echo "<td class='lt3' align='center' valign='midle'>";
	echo "<b>".$_titulo."</b>";
	echo "</td>";
	echo "</tr>";

	//echo "<IMG SRC='http://chart.apis.google.com/chart?&chs=400x200&chds=0,1&chxt=x,y,x&chm=N*p0*,000000,0,-1,11&chd=t:0.01,0.20,0.01&cht=bvg&chxl=0:|117|50|100|2:|Jan|Fev|Mar&chco=0080c0'>";
	echo "<tr>";
	echo "<td align='center' valign='midle'>";

	/*
	echo '<br> dados: '.$_dados;
	echo '<br> label_mes: '.$_label_mes;
	echo '<br>';
	*/

	echo "<IMG border='1' SRC='http://chart.apis.google.com/chart?&chs=500x200&chds=0,1&chxt=x,y&chds=0,".$topo."&chxr=1,0,".$topo."&chd=t:".$_dados."&cht=bvs&chxl=0:".$_label_mes."&chco=2dbbff'>";
	echo '<br><br>';	
	echo "</td>";
	echo "</tr>";
}

function ordena_array($dados, $colunas, $ordenarColuna){
	$dados_bkp=array();
	$dados_bkp=$dados;	
	//print_r($dados_bkp);
	$linhas=array();
	for($i=0; $i<count($dados); $i++){
		array_push($linhas, $i);	
	}
	
}
?>
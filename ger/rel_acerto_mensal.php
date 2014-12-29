<?
$include = '../';
require($include."cab.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");
require($include."sisdoc_debug.php");
require($include."google_chart.php");
require($include."letras.css");
require($include."biblioteca.php");

require("../db_ecaixa.php");

$data = $dd[0];
$equipe = $dd[1];
$loja = $dd[2];

//echo $loja;

if (strlen($loja) == 0){
	exit;
}

$mes=substr($data, 4, 2)*1;
$ano=substr($data, 0, 4);

//echo $mes;
$dt_inicio=$data.'01';
if ($mes==12){
	$mes='01';
	$ano++;
	$dt_fim=$ano.$mes.'01';
}
else{
	$mes=$mes*1;
	$mes++;
	$mes=left_zero($mes,2);
	$dt_fim=$ano.$mes.'01';
}

//ECHO '<br>Dt inicio:'.$dt_inicio;
//ECHO '<br>Dt fim:'.$dt_fim;

//$dt_inicio=calculaDataMaior($mes);

if ($loja=='J'){require("../db_fghi_206_joias.php");$lj='Jóias';}
if ($loja=='M'){require("../db_fghi_206_modas.php");$lj='Modas';}
if ($loja=='O'){$lj='Óculos';}
if ($loja=='C'){$lj='UseBrilhe';}
if ($loja=='S'){require("../db_fghi_206_sensual.php");$lj='Sensual';}

//echo $mes;

$sql="select kh_acerto, sum(kh_pago) as pago , count(*) as total
		from kits_consignado
			inner join clientes on cl_cliente = kh_cliente
		where kh_acerto >= ".$dt_inicio." and kh_acerto < ".$dt_fim."
			and cl_clientep like '%".$equipe."%'
		group by kh_acerto
		order by kh_acerto";
//echo '<br>Sql: '.$sql;
$rlt = db_query($sql);

$mes=array();
$vlr=array();
$vls=array();
$vlm=array();
$vlt=array();

while ($line = db_read($rlt)){
	array_push($mes,$line['kh_acerto']);
//	array_push($vlr,$line['pago']);
	array_push($vlr,$line['total']);	
	array_push($vlt,$line['pago']);
	array_push($vls,0);
	array_push($vlm,0);
}

$rlt = db_query($sql);

$ini = 0;
while ($line = db_read($rlt)){
	$vl_pago_x = $line['pago'];
	$vl_acer_x = $line['total'];
	$dt_acerto = $line['kh_acerto'];

	$col_joias .= '<TR '.coluna().'><TD>'.stodbr($dt_acerto).'</TD><TD align="center">'.number_format($vl_acer_x,0).'</TD><TD align="right">'.number_format($vl_pago_x,2).'</TD><TD align="right">'.number_format($vl_pago_x/$vl_acer_x,2).'</TD></TR>';
	$tt_joias+=$line['pago'];
	$tt_acer+=$line['total'];

	for ($r = 0; $r < count($mes); $r++){
		if ($mes[$r] == $dt_acerto){
			$vlj[$r] = $vl_acer_x;
		}
	}
}	
////////////////////////////////////////////////////////////////////////////////// GERAR GRÀFICO

$jc = '';
$med = 0;
for ($r = 0; $r < count($mes);$r++){
	$vlrj = $vlj[$r];
	$dt = $mes[$r];
	if ($med == 0) { $med = $vlrj; } 
	else { $med = $med + $vlrj; }
	$medx = round($med / ($r +1));
	$jc .= "data.setValue(".$r.", 0, '".substr($dt,6,2)."');".chr(13).chr(10);
	$jc .= "data.setValue(".$r.", 1, ".$vlrj.");".chr(13).chr(10);
	$jc .= "data.setValue(".$r.", 2, ".$medx.");".chr(13).chr(10);
}
//echo "<br><br><br>jc = ".$jc;
echo '<CENTER><FONT class="lt5">Gráfico da loja '.$lj.'<BR>'.$equipe.'</FONT></CENTER><BR>';
?>

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Ano');
        data.addColumn('number', '<?=$lj;?>');
        data.addColumn('number', 'média');
        data.addRows(<?=count($mes);?>);
		<?=$jc;?>
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 800, height: 350, title: 'Fonzaghi - Acertos mensais'});
      }
    </script>
  </head>

  <body>
    <div id="chart_div"></div>
  </body>

<?$size=130;?>
<table border="0"  class="1_naoLinhaVertical" width="<?=$tab_max;?>" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<TR><TD><B>Metodologia</B>: Recupera a quantidade de acerto e valor faturado por dias individuais. A linha azul representa o número de acertos realizados na loja em cada dia, a linha vermelha indica a média acumulada dos acertos no referido mês.</TD></TR>
</table>
<BR>
<CENTER><FONT class="lt5">Dados do gráfico<BR><?=$eq;?></FONT></CENTER><BR>
<table border="0"  class="1_naoLinhaVertical" width="<?=$tab_max;?>" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<TR>

<td valign="top">
<table border="0" width="400"  class="lt1" width="<?=$size;?>" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<TR bgcolor="#c0c0c0">
<TH class="1_th">Data</TH>
<TH class="1_th">Acertos.</TH>
<TH class="1_th">Vlr.</TH>
<TH class="1_th">Média</TH>
<?=$col_joias;?>
</TR>

<tr>
<td class="legendatotal">Total</td>
<td class="total"><?=number_format($tt_acer,0);?> / <?=number_format($tt_acer / count($mes),0);?></td>
<td class="total"><?=number_format($tt_joias,2);?></td>
<td class="total"><?=number_format($tt_joias / $tt_acer,2);?></td>

</tr>
</table>
</td>

</TR>
</table>  
<?
require($vinclude."foot.php");	
?>
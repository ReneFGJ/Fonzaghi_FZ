<?
$include = '../';
require($include."cab.php");
require($include."sisdoc_colunas.php");
require($include."sisdoc_data.php");
require($include."sisdoc_debug.php");
require($include."google_chart.php");
require($include."letras.css");
require("../db_ecaixa.php");

$loja = $dd[0];
$eqi  = $dd[1];

$mes = date("m");
$ano = date("Y");
$eq = $dd[1];
require("../db_fghi_206_joias.php");

$sql = "select count(*) as acertos, substr(to_char(kh_acerto,'00000000'),1,7) as data from kits_consignado ";
$sql .= "inner join clientes on cl_cliente = kh_cliente ";
$sql .= " where kh_acerto >= ".(date("Y")-2).date("m")."01 ";
if (strlen($eq) > 0) { $sql .= " and cl_clientep = '".$eq."' "; }
$sql .= " group by data order by data ";

//echo "<br> Sql 1:".$sql;

$rlt = db_query($sql);


$max = 1;
$mes = array();
$vlr = array();
$vls = array();
$vlm = array();
$vlo = array();
$vlu = array();
$jc = '';
$ini = 0;
$tt_joias=0;$tt_modas=0;$tt_oculos=0;$tt_catalogo=0;$tt_sensual=0;

while ($line = db_read($rlt))
	{
	$vlrx = $line['acertos'];
	
	$dt = trim($line['data']);

	$vlrx_link = '<A HREF="rel_acerto_mensal.php?dd0='.$dt.'&dd1='.$eq.'&dd2=J">'.$vlrx.'</A>';
	$dt_link = '<A HREF="rel_acerto_mensal.php?dd0='.$dt.'&dd1='.$eq.'&dd2=J">'.substr($dt,0,4).'-'.substr($dt,4,2).'</A>';
	
	$col_joias ='<TR '.coluna().'><TD>'.$dt_link.'</TD><TD align="right">'.$vlrx_link.'</TD></TR>'.$col_joias;
	$tt_joias+=$line['acertos'];
	
	if ($vlrx > $max) { $max = $vlrx; }
	array_push($mes,$dt);
	array_push($vlr,$line['acertos']);
	array_push($vls,0);
	array_push($vlm,0);
	array_push($vlo,0);
	array_push($vlu,0);
	$ini++;
	}

?>	
<CENTER><FONT class="lt5">Acertos Lojas Fonzaghi<BR><?=$eq;?></FONT></CENTER><BR>
<?
////////////////////////////////////////////////////////////////////////////////////////// SENSUAL
$col_sensual = '';
require("../db_fghi_206_sensual.php");
$sql = "select count(*) as acertos, substr(to_char(kh_acerto,'00000000'),1,7) as data from kits_consignado ";
$sql .= "inner join clientes on cl_cliente = kh_cliente ";
$sql .= " where kh_acerto >= ".(date("Y")-2).date("m")."01 ";
if (strlen($eq) > 0) { $sql .= " and cl_clientep = '".$eq."' "; }
$sql .= " group by data order by data ";

//echo "<br> Sql 2:".$sql;

$rlt = db_query($sql);

$ini = 0;
while ($line = db_read($rlt))
	{
	$vlrx = $line['acertos'];
	
	$dt = trim($line['data']);
	
	$vlrx_link = '<A HREF="rel_acerto_mensal.php?dd0='.$dt.'&dd1='.$eq.'&dd2=S">'.$vlrx.'</A>';
	$dt_link = '<A HREF="rel_acerto_mensal.php?dd0='.$dt.'&dd1='.$eq.'&dd2=S">'.substr($dt,0,4).'-'.substr($dt,4,2).'</A>';

	$col_sensual = '<TR '.coluna().'><TD>'.$dt_link.'</TD><TD align="right">'.$vlrx_link.'</TD></TR>'.$col_sensual	;
	
	$tt_sensual+=$line['acertos'];
	
	for ($r = 0; $r < count($mes); $r++)
		{
		if ($mes[$r] == $dt)
			{
			$vls[$r] = $vlrx;
			}
		}
	}
	
////////////////////////////////////////////////////////////////////////////////////////// MODAS
require("../db_fghi_206_modas.php");
$sql = "select count(*) as acertos, substr(to_char(kh_acerto,'00000000'),1,7) as data from kits_consignado ";
$sql .= "inner join clientes on cl_cliente = kh_cliente ";
$sql .= " where kh_acerto >= ".(date("Y")-2).date("m")."01 ";
if (strlen($eq) > 0) { $sql .= " and cl_clientep = '".$eq."' "; }
$sql .= " group by data order by data ";

//echo "<br> Sql 3:".$sql;

$rlt = db_query($sql);

$ini = 0;
while ($line = db_read($rlt))
	{
	$vlrx = $line['acertos'];
	$dt = trim($line['data']);
	
	$vlrx_link = '<A HREF="rel_acerto_mensal.php?dd0='.$dt.'&dd1='.$eq.'&dd2=M">'.$vlrx.'</A>';
	$dt_link = '<A HREF="rel_acerto_mensal.php?dd0='.$dt.'&dd1='.$eq.'&dd2=M">'.substr($dt,0,4).'-'.substr($dt,4,2).'</A>';

	$col_modas = '<TR '.coluna().'><TD>'.$dt_link.'</TD><TD align="right">'.$vlrx_link.'</TD></TR>'.$col_modas;
	$tt_modas+=$line['acertos'];
	
	for ($r = 0; $r < count($mes); $r++)
		{
		if ($mes[$r] == $dt)
			{
			$vlm[$r] = $vlrx;
			}
		}
	}	
	
////////////////////////////////////////////////////////////////////////////////////////// OCULOS
require("../db_fghi_206_oculos.php");
$sql = "select count(*) as acertos, substr(to_char(kh_acerto,'00000000'),1,7) as data from kits_consignado ";
$sql .= "inner join clientes on cl_cliente = kh_cliente ";
$sql .= " where kh_acerto >= ".(date("Y")-2).date("m")."01 ";
if (strlen($eq) > 0) { $sql .= " and cl_clientep = '".$eq."' "; }
$sql .= " group by data order by data ";

//echo "<br> Sql 3:".$sql;

$rlt = db_query($sql);

$ini = 0;
while ($line = db_read($rlt))
	{
	$vlrx = $line['acertos'];
	$dt = trim($line['data']);
	
	$vlrx_link = '<A HREF="rel_acerto_mensal.php?dd0='.$dt.'&dd1='.$eq.'&dd2=M">'.$vlrx.'</A>';
	$dt_link = '<A HREF="rel_acerto_mensal.php?dd0='.$dt.'&dd1='.$eq.'&dd2=M">'.substr($dt,0,4).'-'.substr($dt,4,2).'</A>';

	$col_oculos = '<TR '.coluna().'><TD>'.$dt_link.'</TD><TD align="right">'.$vlrx_link.'</TD></TR>'.$col_oculos;
	$tt_oculos+=$line['acertos'];
	
	for ($r = 0; $r < count($mes); $r++)
		{
		if ($mes[$r] == $dt)
			{
			$vlo[$r] = $vlrx;
			}
		}
	}
	
////////////////////////////////////////////////////////////////////////////////////////// USEBRILHE
require("../db_fghi_206_ub.php");
$sql = "select count(*) as acertos, substr(to_char(kh_acerto,'00000000'),1,7) as data from kits_consignado ";
$sql .= "inner join clientes on cl_cliente = kh_cliente ";
$sql .= " where kh_acerto >= ".(date("Y")-2).date("m")."01 ";
if (strlen($eq) > 0) { $sql .= " and cl_clientep = '".$eq."' "; }
$sql .= " group by data order by data ";

//echo "<br> Sql 3:".$sql;

$rlt = db_query($sql);

$ini = 0;
while ($line = db_read($rlt))
	{
	$vlrx = $line['acertos'];
	$dt = trim($line['data']);
	
	$vlrx_link = '<A HREF="rel_acerto_mensal.php?dd0='.$dt.'&dd1='.$eq.'&dd2=M">'.$vlrx.'</A>';
	$dt_link = '<A HREF="rel_acerto_mensal.php?dd0='.$dt.'&dd1='.$eq.'&dd2=M">'.substr($dt,0,4).'-'.substr($dt,4,2).'</A>';

	$col_catalogo = '<TR '.coluna().'><TD>'.$dt_link.'</TD><TD align="right">'.$vlrx_link.'</TD></TR>'.$col_catalogo;
	$tt_catalogo+=$line['acertos'];
	
	for ($r = 0; $r < count($mes); $r++)
		{
		if ($mes[$r] == $dt)
			{
			$vlu[$r] = $vlrx;
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////// GERAR GRÀFICO

$jc = '';
	for ($r = 0; $r < count($mes);$r++)
	{
	$vlrx = $vlr[$r];
	$vlrs = $vls[$r];
	$vlrm = $vlm[$r];
	$vlro = $vlo[$r];
	$vlru = $vlu[$r];
	$dt = $mes[$r];
	$jc .= "data.setValue(".$r.", 0, '".substr($dt,0,4).'-'.substr($dt,4,2)."');".chr(13).chr(10);
	$jc .= "data.setValue(".$r.", 1, ".$vlrx.");".chr(13).chr(10);
	$jc .= "data.setValue(".$r.", 2, ".$vlrm.");".chr(13).chr(10);
	$jc .= "data.setValue(".$r.", 3, ".$vlro.");".chr(13).chr(10);
	$jc .= "data.setValue(".$r.", 4, ".$vlru.");".chr(13).chr(10);
	$jc .= "data.setValue(".$r.", 5, ".$vlrs.");".chr(13).chr(10);
	}
	//echo "<br><br><br>jc = ".$jc;
?>

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Ano');
        data.addColumn('number', 'Jóias');
        data.addColumn('number', 'Modas');
        data.addColumn('number', 'Óculos');
        data.addColumn('number', 'Catálogo');
        data.addColumn('number', 'Sensual');
        data.addRows(<?=count($mes);?>);
		<?=$jc;?>
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, {width: 800, height: 350, title: 'Fonzaghi - Acertos'});
      }
    </script>
  </head>

  <body>
    <div id="chart_div"></div>
  </body>
  
  <table class="lt1" width="<?=$tab_max;?>">
  	<TR><TD colspan="10"><HR></TD></TR>
	<TR>
		<TD><a href="rel_acerto.php?dd0=<?=$dd[0];?>&dd1=">::Todas equipes::</a></TD>
		<TD><a href="rel_acerto.php?dd0=<?=$dd[0];?>&dd1=AMARELO">::AMARELO::</a></TD>
		<TD><a href="rel_acerto.php?dd0=<?=$dd[0];?>&dd1=AZUL">::AZUL::</a></TD>
		<TD><a href="rel_acerto.php?dd0=<?=$dd[0];?>&dd1=ROSA">::ROSA::</a></TD>
		<TD><a href="rel_acerto.php?dd0=<?=$dd[0];?>&dd1=VERDE">::VERDE::</a></TD>
	</TR>  
  </table>  
<br><br>

<?$size=130;?>

<br>
<CENTER><FONT class="lt5">Visualizar acertos mansais<BR><?=$eq;?></FONT></CENTER><BR>
<table border="0"  class="1_naoLinhaVertical" width="<?=$tab_max;?>" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<TR>

<td valign="top">
<table border="0"  class="1_naoLinhaVertical" width="<?=$size;?>" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<TR>
<TH colspan="2" class="1_th">Jóias</TH>
<?=$col_joias;?>
</TR>

<tr>
<td class="legendatotal">Total</td>
<td class="total"><?=$tt_joias;?></td>
</tr>
</table>
</td>

<td valign="top">
<table border="0"  class="1_naoLinhaVertical" width="<?=$size;?>" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<TR>
<TH colspan="2" class="1_th">Modas</TH>
<?=$col_modas;?>
</TR>
<tr>
<td class="legendatotal">Total</td>
<td class="total"><?=$tt_modas;?></td>
</tr>
</table>
</td>

<td valign="top">
<table border="0"  class="1_naoLinhaVertical" width="<?=$size;?>" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<TR>
<TH colspan="2" class="1_th">Óculos</TH>
<?=$col_oculos;?>
</TR>
<tr>
<td class="legendatotal">Total</td>
<td class="total"><?=$tt_oculos;?></td>
</tr>

</table>
</td>

<td valign="top">
<table border="0"  class="1_naoLinhaVertical" width="<?=$size;?>" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<TR>
<TH colspan="2" class="1_th">Catálogo</TH>
<?=$col_catalogo;?>
</TR>

<tr>
<td class="legendatotal">Total</td>
<td class="total"><?=$tt_catalogo;?></td>
</tr>
</table>
</td>

<td valign="top">
<table border="0"  class="1_naoLinhaVertical" width="<?=$size;?>" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<TR>
<TH colspan="2" class="1_th">Sensual</TH>
<?=$col_sensual;?>
</TR>

<tr>
<td class="legendatotal">Total</td>
<td class="total"><?=$tt_sensual;?></td>
</tr>
</table>
</td>

</TR>
</table>

<?
require($vinclude."foot.php");	
?>
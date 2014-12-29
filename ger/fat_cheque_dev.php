<?php

$ddx = date("Ymd");
echo '<h1>Cheques devolvido</h1>';
require("../_db/db_caixa_central.php");
$nohd = 0;
$dados = '';
$meses = 13;

$sql = "
select sum(valor) as valor, count(*) as total, mes
	from (
		select ext_valor as valor, round(ext_data/100) as mes
			from banco_extrato
		where ext_tipo = 'DEV'
		and ext_data >= 20000101 and ext_data <= ".date("Ymd")."
		) as tabela group by mes
		order by mes desc
	";
$rlt = db_query($sql);
echo '<TABLE width="100%">';
$lista = array();
while ($line = db_read($rlt))
	{
	$dd1=$line['mes'];	
	$dados .= ', '.chr(13).chr(10). "['".substr($dd1,4,2)."/".substr($dd1,0,4).
			", ".(round($line['valor'])).
			", ".round($line['total'])."] ";
	echo '<TR>';
	echo '<TD align="center" class="tabela01">'.substr($line['mes'],4,2).'/'.substr($line['mes'],0,4);
	echo '<TD align="center" class="tabela01">'.fmt($line['valor'],2);
	echo '<TD align="center" class="tabela01">'.$line['total'];
	/* Exportar dados para Banco de Variaveis */
	array_push($lista,array(substr($line['mes'],0,4),substr($line['mes'],4,2),'',$line['total'],$line['valor'],0));	
	}
echo '</table>';

/* Alimenta banco variaveis */
require("../_db/db_variaveis.php");
$bv->alimenta_lista('FZGHI-FIN-CHEQUE-DEV',$lista);

echo '
    <script type="text/javascript">
      google.load(\'visualization3\', \'1\', {packages: [\'corechart\']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable([
          [\'Year\', \'Total Geral\', \'Cheques\']
		'.$dados.'
        ]);
      
        // Create and draw the visualization.
        new google.visualization.AreaChart(document.getElementById(\'visualization3\')).
            draw(data,
                 {title:"Composi�ao dos recebimentos juridico",
                  width:1000, height:400,
                  hAxis: {title: "Year"}}
            );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  <center>
    <div id="visualization3" style="width: 1000px; height: 400px;"></div>
';

echo '</center>';
?>
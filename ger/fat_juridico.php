<?php

$ddx = date("Ymd");
echo '<h1>Recebimentos Juridico</h1>';
require("../_db/db_ecaixa.php");
$nohd = 0;
$dados = '';
$meses = 25;
for ($r=0;$r < $meses;$r++)
	{
	$dd1 = substr($ddx,0,6).'01';
	$dd2 = substr($ddx,0,6).'01';
	echo $cc->saldo_receita($dd1,$dd2,$nohd,1);
	$dx = $cc->resumo_caixa;
	$nohd = 1;
	$ddx = DateAdd('m',-1,$ddx);
	
	
	$complemento = '';
	if ($r < $meses) { $complemento = ', '.chr(13); }
	
	$dados = "['".substr($dd1,4,2)."/".substr($dd1,0,4)."', ".
			round($dx[4]).", ".
			round($dx[0]).", ".
			round($dx[1]).", ".
			round($dx[2]).", ".
			round($dx[3])."]"
			.$complemento 
			.$dados;
				
	}
echo '</table>';

echo '
    <script type="text/javascript">
      google.load(\'visualization2\', \'1\', {packages: [\'corechart\']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable([
          [\'Year\', \'Total Geral\', \'Dinheiro\', \'Cartões\', \'Cheques/Depóisto\', \'Outros\'],
		'.$dados.'
        ]);
      
        // Create and draw the visualization.
        new google.visualization.AreaChart(document.getElementById(\'visualization2\')).
            draw(data,
                 {title:"Composiçao dos recebimentos juridico",
                  width:1000, height:400,
                  hAxis: {title: "Year"}}
            );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  <center>
    <div id="visualization2" style="width: 1000px; height: 400px;"></div>
';

echo '</center>';
?>
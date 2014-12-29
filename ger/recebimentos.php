<?php
$breadcrumbs=array();
array_push($breadcrumbs, array('/fonzaghi/main.php','Home'));
array_push($breadcrumbs, array('/fonzaghi/financeiro/caixa_central.php','Caixa Central'));

$include = '../';
require("../cab_novo.php");
require($include.'sisdoc_colunas.php');
require($include.'sisdoc_data.php');
require($include.'sisdoc_windows.php');

/*
 * Banco de Variaveis
 */
 require("../../fonzaghi/_class/_class_banco_variaveis.php");
 $bv = new banco_variavel;

require("../../fonzaghi/_class/_class_caixa_cental.php");
$cc = new caixa_central;

$ddx = date("Ymd");
echo '<h1>Recebimentos</h1>';
require("../_db/db_ecaixa.php");
$nohd = 0;
$dados = '';
$meses = 13;
$meses = 48;
for ($r=0;$r < $meses;$r++)
	{
	$dd1 = substr($ddx,0,6).'01';
	$dd2 = substr($ddx,0,6).'01';
	echo $cc->saldo_receita($dd1,$dd2,$nohd);
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
    <script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load(\'visualization\', \'1\', {packages: [\'corechart\']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable([
          [\'Year\', \'Total Geral\', \'Dinheiro\', \'Cartoes\', \'Cheques/Deposito\', \'Outros\'],
		'.$dados.'
        ]);
      
        // Create and draw the visualization.
        new google.visualization.AreaChart(document.getElementById(\'visualization\')).
            draw(data,
                 {title:"Composição dos Recebimentos",
                  width:1600, height:400,
                  hAxis: {title: "Ano"}}
            );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  <center>
    <div id="visualization" style="width: 1600px; height: 400px;"></div>
';
echo '</center>';

require("fat_juridico.php");
echo '<HR>';
require("fat_cheque_dev.php");
echo '<HR>';
echo $hd->foot();
?>
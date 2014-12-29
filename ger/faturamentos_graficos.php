   <center> <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Dia');
		<? for ($r=0;$r < count($fid);$r++) { ?>
	        data.addColumn('number', '<?=$fid[$r];?>');
		<? } ?>		
        data.addRows(<?=count($vlr[0]);?>);

		<? for ($y=0;$y < count($vlr[0]);$y++) { ?>
				data.setValue(<?=$y;?>, 0, '<?=nomemes_short($y+1);?>');
			<? for ($r=0;$r < count($fid);$r++) { ?>
				data.setValue(<?=$y;?>, <?=($r+1);?>, <?=round('0'.($vlr[$r][$y]/100)/10);?>);
			<? } ?>		
		<? } ?>		
		
        var chart = new google.visualization.LineChart(document.getElementById('chart_div<?=$id;?>'));
        chart.draw(data, {width: 800, height: 350, title: 'Fonzaghi - faturamento - <?=$yloja;?>'});
      }
    </script>

  	<center><table border="1">
	<TR><TD>
    <div id="chart_div<?=$id;?>"></div>
	</table>
<?
$id++;
?>
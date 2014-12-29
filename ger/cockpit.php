<!--
You are free to copy and use this sample in accordance with the terms of the
Apache license (http://www.apache.org/licenses/LICENSE-2.0.html)
-->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>
      Google Visualization API Sample
    </title>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1.1', {packages: ['controls']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Prepare the data.
        var data = google.visualization.arrayToDataTable([
          ['Metric', 'Value'],
          ['CPU' , 12],
          ['Memory', 20],
          ['Disk', 7],
          ['Network', 54]
        ]);
      
        // Define a category picker for the 'Metric' column.
        var categoryPicker = new google.visualization.ControlWrapper({
          'controlType': 'CategoryFilter',
          'containerId': 'control1',
          'options': {
            'filterColumnLabel': 'Metric',
            'ui': {
              'allowTyping': false,
              'allowMultiple': true,
              'selectedValuesLayout': 'belowStacked'
            }
          },
          // Define an initial state, i.e. a set of metrics to be initially selected.
          'state': {'selectedValues': ['CPU', 'Memory']}
        });
      
        // Define a gauge chart.
        var gaugeChart = new google.visualization.ChartWrapper({
          'chartType': 'Gauge',
          'containerId': 'chart1',
          'options': {
            'width': 400,
            'height': 180
          }
        });
      
        // Create the dashboard.
        var dashboard = new google.visualization.Dashboard(document.getElementById('dashboard')).
          // Configure the category picker to affect the gauge chart
          bind(categoryPicker, gaugeChart).
          // Draw the dashboard
          draw(data);
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
  </head>
  <body style="font-family: Arial;border: 0 none;">
    <div id="dashboard">
      <table>
        <tr style='vertical-align: top'>
          <td style='width: 300px; font-size: 0.9em;'>
            <div id="control1"></div>
            <div id="control2"></div>
            <div id="control3"></div>
          </td>
          <td style='width: 600px'>
            <div style="float: left;" id="chart1"></div>
            <div style="float: left;" id="chart2"></div>
            <div style="float: left;" id="chart3"></div>
          </td>
        </tr>
      </table>
    </div>
  </body>
</html>
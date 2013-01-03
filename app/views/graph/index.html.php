<h4>Graph</h4>
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  <script type="text/javascript">
    google.load('visualization', '1', {packages: ['corechart']});
    function drawVisualization() {
       // Populate the data table.
        var dataTable = google.visualization.arrayToDataTable([
 <?php echo $data;?>
         // Treat first row as data as well.
        ], true);
    
        // Draw the chart.
        var chart = new google.visualization.CandlestickChart(document.getElementById('visualization'));
        chart.draw(dataTable, {legend:'none', width:800, height:400});
    }    
    google.setOnLoadCallback(drawVisualization);
  </script>
  <div id="visualization" style="width: 800px; height: 400px;"></div>

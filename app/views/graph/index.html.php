<h4>Graph: Candlestick</h4>
Daily High, Low, Open, Close
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  <script type="text/javascript">
    google.load('visualization', '1', {packages: ['corechart']});
    function drawVisualization() {
       // Populate the data table.
        var dataTable = google.visualization.arrayToDataTable([
		 <?php echo $Graphdata;?>
         // Treat first row as data as well.
        ], true);
        // Draw the chart.
        var chart = new google.visualization.CandlestickChart(document.getElementById('visualization'));
        chart.draw(dataTable, {legend:'none', width:800, height:400});
    }    
    google.setOnLoadCallback(drawVisualization);
  </script>
  <div id="visualization" style="width: 800px; height: 400px;"></div>
  <h5>I invested 100 BTC on 7th January 2013</h5>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>Date</th>
			<th colspan="2" style="text-align:center ">Amount</th>
			<th colspan="2" style="text-align:center ">Increase</th>
		</tr>
		<tr>
			<th></th>
			<th>USD</th>
			<th>INR</th>
			<th>USD</th>
			<th>INR</th>
		</tr>
	</thead>
	<tbody>
<?php 
$i = 0;
foreach($tableData as $t){
if( $i % 7==0){
?>
		<tr>
			<td><?=$t['date']?></td>
			<td><?=(100 * $t['USD'])?></td>						
			<td><?=round(100 * $t['USD']* $t['INR'],0)?></td>									
			<td><?=round((100 * $t['USD'])/$tableInit['USD']-100,0)?>%</td>									
			<td><?=round(round(100 * $t['USD']* $t['INR'],0)/(round(100 * $tableInit['USD']* $tableInit['INR'],0))-1,2)*100?>%</td>
		</tr>
<?php 
}
$i++;
}?>
	</tbody>
</table>
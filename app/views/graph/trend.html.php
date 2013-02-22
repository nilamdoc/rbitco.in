<h4>Graph: Trend</h4>
INR-USD, BTC, Volume in 1000.
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable([
          ['x', 'INR', 'BTC', 'VOL\'K'],
		  <?php echo $Graphdata;?>
        ]);
      
        // Create and draw the visualization.
        new google.visualization.LineChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                        width: 800, height: 400,
                        vAxis: {maxValue: 10}}
                );
      }
      

      google.setOnLoadCallback(drawVisualization);
    </script>
    <div id="visualization" style="width: 500px; height: 400px;"></div>
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
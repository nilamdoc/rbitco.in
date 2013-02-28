Increase of BTC over time
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
    <script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = google.visualization.arrayToDataTable([
          ['Year', 'BTC'],
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

<h4>Statistics </h4>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>Block</th>
			<th>Reward Era</th>
			<th>BTC/Block</th>
			<th>Year*</th>			
			<th>Start BTC</th>						
			<th>BTC Added</th>									
			<th>End BTC</th>									
			<th>BTC Increase%</th>									
			<th>End BTC % of limit</th>									
		</tr>
	</thead>
	<tbody>
	<?php
	foreach($bitcoins as $b){?>
		<tr>
			<td><?=$b['block']?></td>
			<td><?=$b['reward']?></td>			
			<td><?=number_format($b['btc_block'],8)?></td>			
			<td><?=number_format($b['year'],3)?></td>						
			<td><?=number_format($b['start'],4)?></td>			
			<td><?=number_format($b['added'],4)?></td>						
			<td><?=number_format($b['end'],4)?></td>						
			<td><?=number_format($b['increase'],8)?>%</td>						
			<td><?=number_format($b['endlimit'],8)?></td>						
		</tr>
	
	<?php
	}
	?>
	
	</tbody>
</table>
* Approx year<br>
Source: <a href="https://en.bitcoin.it/wiki/Controlled_supply" target="_blank">https://en.bitcoin.it/wiki/Controlled_supply</a>
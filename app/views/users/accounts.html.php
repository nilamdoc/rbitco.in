<h4>Your accounts:</h4>
Only latest <?php if($countAccounts<=50){echo $countAccounts;}else{echo "50";}?> records displayed:
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>Date</th>
			<th>Amount BTC</th>
			<th>Description</th>
			<th>Reference</th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach($Accounts as $a){
?>
	<tr>
		<td><?=$a['date']?></td>
		<td><?=number_format($a['amount'],7)?></td>		
		<td><?=$a['description']?></td>				
		<td><?=$a['refer']?></td>						
	</tr>
<?php
	}
?>
	<tr>
		<td><strong>Total of all <?=$countAccounts?> records</strong></td>
		<td><strong><?=number_format($sumAccounts['result'][0]['amount'],7)?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>		
	</tr>
</tbody>
</table>
<hr>
Parents<br>
<?php
foreach($ParentDetails as $parent){
	print_r($parent['left']);
	echo "--";
	print_r($parent['user_id']);	
	echo "<br>";	
}
?>
<hr>Child<br>
<?php
foreach($NodeDetails as $node){
	print_r($node['left']);
	echo "--";
	print_r($node['user_id']);	
	echo "<br>";	
}
?>
<hr>

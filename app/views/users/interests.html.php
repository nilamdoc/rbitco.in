<h4>Interest calculations</h4>
<p>Interest is calculated daily. It will be automatically transferred to your wallet at the end of the month. Once it is transfered to your wallet, you can withdraw the BTC from your wallet.</p>
<table class="table table-condensed table-striped table-bordered" style="background-color:white;width:50% ">
	<thead>
		<tr>
			<th>Date</th>
			<th>Amount BTC</th>
		</tr>
	</thead>
	<tbody>
<?php
	foreach($Interests as $a){
?>
	<tr>
		<td><?=$a['datetime']['date']?>&nbsp;<?=$a['datetime']['time']?></td>
		<td><?=number_format($a['interest'],8)?></td>
	</tr>
<?php
	$total = $total + $a['interest'];
}
?>
	<tr>
		<td><strong>Total</strong></td>
		<td><strong><?=number_format($total,8)?></strong></td>
	</tr>
	</tbody>
</table>
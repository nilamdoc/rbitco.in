<h4>Transactions:</h4>
Bitcoin address: <br>
<strong><?php foreach($wallet['wallet']['address'] as $a){echo $a."<br>";}?></strong>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>#</th>
			<th>Type</th>
			<th>Amount</th>
			<th>Confirmations</th>
			<th>Block Hash</th>
			<th>Block Index</th>			
			<th>TxID</th>
			<th>Time</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
		foreach($listTransactions['transactions']['transactions'] as $t){

		if(in_array($t['address'],$wallet['wallet']['address'])){
		$i++;
	?>
		<tr>
			<td><?=$i?></td>
			<td><?=$t['category']?></td>
			<td><?=number_format($t['amount'],7)?></td>
			<td><?php if($t['category']=='receive'){echo $t['confirmations'];}?></td>			
			<td><?php if($t['category']=='receive' && $t['confirmations']>0){echo "<a href='/network/blockhash/".$t['blockhash']."'>".substr($t['blockhash'],0,20)."...</a>";}?></td>
			<td><?php if($t['category']=='receive' && $t['confirmations']>0){echo $t['blockindex'];}?></td>			
			<td><?php if($t['category']=='receive' && $t['confirmations']>0){echo "<a href='/network/transactionhash/".$t['txid']."'>".substr($t['txid'],0,20)."...</a>";}?></td>
			<td><?=date('Y-m-d H:i:s',$t['time'])?></td>									
		</tr>
	<?php
	}
	}
	?>
	</tbody>
</table>
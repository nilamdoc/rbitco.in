<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<tr>
		<td>Next Block </td>
		<td><a href="/network/blockhash/<?=$nextblockhash?>"><?=$nextblockhash?></a></td>
		<td><?=$nextblock?></td>
	</tr>	
	<tr>
		<td>Hash</td>
		<td><strong><?=$getblock['hash']?></strong></td>
		<td><strong><?=$getblock['height']?></strong></td>
	</tr>
	<tr>
		<td>Prev Block </td>
		<td><a href="/network/blockhash/<?=$prevblockhash?>"><?=$prevblockhash?></a></td>
		<td><?=$prevblock?></td>
	</tr>		
</table>
<h3>Details:</h3>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<tr>
		<td>Hash</td>
		<td><strong><?=$getblock['hash']?></strong></td>
	</tr>
	<tr>
		<td>Block</td>
		<td><strong><?=$getblock['height']?></strong></td>
	</tr>
	<tr>
		<td>Confirmations</td>
		<td><?=$getblock['confirmations']?></td>
	</tr>
	<tr>
		<td>Size</td>
		<td><?=$getblock['size']?></td>
	</tr>
	<tr>
		<td>Version</td>
		<td><?=$getblock['version']?></td>
	</tr>
	<tr>
		<td>Merkle root</td>
		<td><?=$getblock['merkleroot']?></td>
	</tr>	
	<tr>
		<td>Time</td>
		<td><?=$getblock['time']?></td>
	</tr>		
	<tr>
		<td>Nonce</td>
		<td><?=$getblock['nonce']?></td>
	</tr>		
	<tr>
		<td>Bits</td>
		<td><?=$getblock['bits']?></td>
	</tr>		
	<tr>
		<td>Difficulty</td>
		<td><?=$getblock['difficulty']?></td>
	</tr>		
</table>
<h3>Transaction in this block:</h3>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>ID</th>
			<th>Transaction hash</th>
		</tr>
	</thead>
<?php $tx = count($getblock['tx']);
	for($i=0;$i<$tx;$i++){
?>
	<tr>
		<td><?=$i?></td>
		<td><a href="/network/transactionhash/<?php print_r($getblock['tx'][$i])?>"><?php print_r($getblock['tx'][$i])?></a></td>
	</tr>		
<?php }?>
</table>
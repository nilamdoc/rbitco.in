<div>
<table>
<thead>
<tr>
	<th>Name</th>
	<th>Balance</th>
</tr>
</thead>
<?php
foreach ($transactions['transactions']['result'] as $t){
?>
<tr>
	<td><a href="/accounts/details/<?=$t['_id']['account']?>"><?=$t['_id']['account']?></a></td>
	<td><?=number_format($t['amount'],8)?></td>
	<td><?=$t['_id']['category']?></td>	
	<td><?=$t['count']?></td>		
	<td><a href="http://blockchain.info/address/<?=$t['_id']['address']?>"><?=$t['_id']['address']?></a></td>			
</tr>


<?php

}
print_r($relation);
?>
</table>
</div>
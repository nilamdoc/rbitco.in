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
	<td><?=$t['_id']['account']?></td>
	<td><?=number_format($t['amount'],8)?></td>
	<td><?=$t['_id']['category']?></td>	
</tr>


<?php

}
?>
</table>
</div>
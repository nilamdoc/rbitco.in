<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>User</th>
			<th>Balance</th>
			<th>Addresses</th>
			<th>Accounts</th>			
			<th>Interest</th>						
		</tr>
	</thead>
	<tbody>
	<?php
	$balance = 0;
	$address = 0;
	$account = 0;
	$interest = 0;
foreach($summary as $u){
?>
	<tr>
		<td><?=$u['wallet']['key']?></td>
		<td><?=number_format($u['wallet']['balance'],8)?></td>
		<td><?php
			for($i=0;$i<=count($u['wallet']['address'])/2-1;$i++){
				echo "<code>".$u['wallet']['address'][$i]."</code>: ".number_format($u['wallet']['address'][$u['wallet']['address'][$i]],8)."<br>";
				$address = $address + number_format($u['wallet']['address'][$u['wallet']['address'][$i]],8);				
			}
			?>
		</td>
		<td>Accounts</td>
		<td>Interest</td>
	</tr>
<?php
$balance = $balance + number_format($u['wallet']['balance'],8);

$account = $account + number_format($u['wallet']['address'][$u['wallet']['address'][$i]],8);
$interest = $interest + number_format($u['wallet']['address'][$u['wallet']['address'][$i]],8);
}
?>
	<tr>
		<td><strong>Total</strong></td>
		<td><?=$balance?></td>
		<td><?=$address?></td>		
		<td><?=$account?></td>
		<td><?=$interest?></td>		
	</tr>
	</tbody>
</table>
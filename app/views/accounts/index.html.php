<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>User</th>
			<th>Balance</th>
			<th>Addresses</th>
			<th>Accounts</th>			
			<th>Interest</th>						
			<th>Total</th>									
		</tr>
	</thead>
	<tbody>
	<?php
	$balance = 0;
	$address = 0;
	$account = 0;
	$interest = 0;
	$gtotal = 0;
foreach($summary as $u){
	$htotal = 0;
?>
	<tr>
		<td><a href="/accounts/signin/<?=$u['wallet']['key']?>/<?=SECURITY_CHECK?>"><?=$u['wallet']['key']?></a><br>
		<a href="mailto:<?=$u['wallet']['email']?>"><?=$u['wallet']['email']?></a></td>
		<td><?=number_format($u['wallet']['balance'],8)?></td>
		<td><?php
			for($i=0;$i<=count($u['wallet']['address'])/2-1;$i++){
				echo "<code><a href='https://rbitco.in/network/address/".$u['wallet']['address'][$i]."' target='_blank'>".$u['wallet']['address'][$i]."</a></code>: ".number_format($u['wallet']['address'][$u['wallet']['address'][$i]],8)."<br>";
				$address = $address + number_format($u['wallet']['address'][$u['wallet']['address'][$i]],8);				
				$htotal = $htotal + number_format($u['wallet']['address'][$u['wallet']['address'][$i]],8)+
				number_format($u['wallet']['accounts'],8)+number_format($u['wallet']['interest'],8);

			}
			?>
		</td>
		<td><?=number_format($u['wallet']['accounts'],8)?></td>
		<td><?=number_format($u['wallet']['interest'],8)?></td>
		<td><?=number_format($htotal,8)?></td>		
	</tr>
<?php
$balance = $balance + number_format($u['wallet']['balance'],8);
$account = $account + number_format($u['wallet']['accounts'],8);
$interest = $interest + number_format($u['wallet']['interest'],8);
	$gtotal = $gtotal + $htotal;
}
?>
	<tr>
		<td><strong>Total</strong></td>
		<td><?=number_format($balance,8)?></td>
		<td><?=number_format($address,8)?></td>		
		<td><?=number_format($account,8)?></td>
		<td><?=number_format($interest,8)?></td>		
		<td><?=number_format($gtotal,8)?></td>				
	</tr>
	</tbody>
</table>
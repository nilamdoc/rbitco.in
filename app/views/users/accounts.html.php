<?php  //exit;?>
<h3>Accounts:</h3>
<h4>Your referal url: <a href="/users/signup/<?=$address?>">https://<?=$_SERVER['SERVER_NAME']?>/users/signup/<?=$address?></a></h4>
<a href="/users/refer" class="btn btn-primary">Refer to friend</a>
<div class="row">
	<div class="span4">
		<h4>Wallet details:</h4>
		
		<p>Wallet name: <strong><?=$username?></strong></p>
		<p>Wallet balance: <a href="/users/transactions"><strong><?php number_format(print_r($wallet),8)?> BTC</strong></a> </p>
		<p>Interest:  <a href="/users/interests"><strong><?php print_r(number_format($interest['interest']['result'][0]['interest'],8))?> BTC for <?=$interestCount?> days</strong></a></p>		

<p>Wallet addresses:<br>
<strong>

<?php

foreach($walletbal['wallet']['address'] as $address){
	echo "<a href='http://blockchain.info/address/".$address."' target='_blank'>".$address."</a><br>";
}

?></strong>
</p>
	</div>
	<div class="span5">
		<h4>Add funds:</h4>
		<div class="btn-group">		
			<a href="/users/addfunds" style="width:100px" class="btn btn-success tooltip-x  " rel='tooltip' title='Add funds to your account'>Add funds</a>
		</div>		

		<h4>Trasact:</h4>
		<div class="btn-group">		
			<a href="/users/transfer" style="width:100px" class="btn btn-primary tooltip-x " rel='tooltip' title='Transfer BTC to another address'>Transfer</a> 
			<a href="/users/withdraw" style="width:100px" class="btn btn-danger tooltip-x  " rel='tooltip' title='Withdraw BTC to any bank'>Withdraw</a>
		</div>
<!--
		<h4>Buy / Sell:</h4>
		<div class="btn-group">		
			<a href="/transact/buy" style="width:100px" class="btn btn-primary tooltip-x  " rel='tooltip' title='Buy BTC to your address'>Buy</a>
			<a href="/transact/sell" style="width:100px" class="btn btn-danger tooltip-x  " rel='tooltip' title='Sell BTC from your address'>Sell</a>		
		</div>		
-->		
	</div>
</div>
<h4>Account details:</h4>

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
	$user_id = $a['user_id'];
?>
	<tr>
		<td><?=$a['datetime']['date']?>&nbsp;<?=$a['datetime']['time']?></td>
		<td><?=number_format($a['amount'],7)?></td>		
		<td><?=$a['description']?></td>				
		<td><?php
		if($a['refer_name']!=""){?>
		<a href='/users/message/<?=$a['user_id']?>/<?=$a['refer_id']?>' class='label label-important tooltip-x' rel='tooltip' title='Thank <?=$a['refer_name']?>' >
		<?=$a['refer_name']?></a>
		<?php }?></td>						
	</tr>
<?php
	}
?>
	<tr>
		<td><strong>Total of all <?=$countAccounts?> records</strong></td>
		<td><strong><?=number_format($sumAccounts['account']['result'][0]['amount'],7)?></strong></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>		
	</tr>
</tbody>
</table>
<h5>Messaging</h5>
<p>Writing a message to a user will give you <span class="label label-important">1</span> bronze point. In the above table only latest 50 records are displayed. So use them to welcome your parent or child notes to the site and earn points. More points, more advantage of earning free BTCs.</p>
<p>If you do not have any child nodes, use the above URL to chat / IRC channels and invite friends for free registration, you will get credit of BTCs. </p>
<p>Check the <a href="/users">payments</a> page.</p>
<?php 
if (count($ancestors)>0){
?>
<h6>Your ancestors</h6>
<?php

foreach($ancestors as $a){
//print_r(count($a['ancestors']));
$count = count($a['ancestors']);
	for($i=0;$i<$count;$i++){
//	print_r($a['ancestors']);
	?>
	<a href='/users/message/<?=$user_id?>/<?=$a['ancestors'][$i]?>' class='label label-important tooltip-x' rel='tooltip' title='Send a message to <?=$a['ancestors'][$i]['']?>' ><?=$a['ancestors'][$i]?></a>&nbsp;
	<?php
	}
}
?>

<?php
}

if (count($descendants)>0){
?>
<h6>Your descendants</h6>
<?php
foreach($descendants as $d){
?>
 <a href='/users/message/<?=$user_id?>/<?=$d['username']?>' class='label label-important tooltip-x' rel='tooltip' title='Send a message to <?=$d['username']?>' ><?=$d['username']?></a>&nbsp;	

<?php
}
?>
<?php
}

?>
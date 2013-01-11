<h4>Your referal url: <a href="http://<?=$_SERVER['SERVER_NAME']?>/users/signup/<?=$address?>">http://<?=$_SERVER['SERVER_NAME']?>/users/signup/<?=$address?></a></h4>
<h4>Wallet details:</h4>
<p>Wallet name: <strong><?=$wallet['wallet']['key']?></strong></p>
<p>Wallet balance: <a href="/users/transactions"><strong><?=number_format($wallet['wallet']['balance'],7)?> BTC</strong></a></p>
<p>Wallet addresses:<br>
<strong>
<?php
foreach($wallet['wallet']['address'] as $address){
	echo $address."<br>";
}
?></strong>
</p>
You can add to this wallet:
<ul>
	<li>Direct payment to the Bitcoin address</li>
	<li>Get free bitcoins from other websites</li>
	<li>Website integration</li>
</ul>
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
		<a href='/users/message/<?=$a['user_id']?>/<?=$a['refer_id']?>' class='label label-warning tooltip-x' rel='tooltip' title='Thank <?=$a['refer_name']?>' >
		<?=$a['refer_name']?></a>
		<?php }?></td>						
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
<h5>Messaging</h5>
<p>Writing a message to a user will give you <span class="label label-warning">1</span> bronze point. In the above table only latest 50 records are displayed. So use them to welcome your parent or child notes to the site and earn points. More points, more advantage of earning free BTCs.</p>
<p>If you do not have any child nodes, use the above URL to chat / IRC channels and invite friends for free registration, you will get credit of BTCs. </p>
<p>Check the <a href="/users">payments</a> page.</p>
<?php 
if (count($ParentUsers)>0){
?>
<h6>You have <?=$countParents?> parents / grand parents</h6>
<?php
	foreach($ParentUsers as $parent){
?>
<a href='/users/message/<?=$user_id?>/<?=$parent['_id']?>' class='label label-warning tooltip-x' rel='tooltip' title='Send a message to <?=$parent['firstname']?>' ><?=$parent['firstname']?></a>&nbsp;
<?php
	}
}
if (count($NodeUsers)>0){
?>
<h6>You have <?php print_r($countNodes)?> child nodes under you</h6>
<?php
	foreach($NodeUsers as $node){
?>
<a href='/users/message/<?=$user_id?>/<?=$node['_id']?>' class='label label-warning tooltip-x' rel='tooltip' title='Send a message to <?=$node['firstname']?>' ><?=$node['firstname']?></a>&nbsp;
<?php
	}
}
?>
<hr>
<script >
$(function() {
	$('.tooltip-x').tooltip();
});
    // popover demo

</script>
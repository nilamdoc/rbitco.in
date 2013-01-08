<h4>Your referal url: <a href="http://<?=$_SERVER['SERVER_NAME']?>/users/signup/<?=$address?>">http://<?=$_SERVER['SERVER_NAME']?>/users/signup/<?=$address?></a></h4>
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
	$user_id = $a['user_id'];
?>
	<tr>
		<td><?=$a['date']?></td>
		<td><?=number_format($a['amount'],7)?></td>		
		<td><?=$a['description']?></td>				
		<td><?php
		if($a['refer_name']!=""){?>
		<a href='/users/message/<?=$a['user_id']?>/<?=$a['refer_id']?>' class='label label-warning' rel='tooltip' title='Thank <?=$a['refer_name']?>' >
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
<?php 
if (count($ParentUsers)>0){
?>
<h6>You have <?=$countParents?> parents / grand parents</h6>
<?php
	foreach($ParentUsers as $parent){
?>
<a href='/users/message/<?=$user_id?>/<?=$parent['_id']?>' class='label label-warning' rel='tooltip' title='Thank <?=$parent['firstname']?>' ><?=$parent['firstname']?></a>,
<?php
	}
}
if (count($NodeUsers)>0){
?>
<h6>You have <?php print_r($countNodes)?> child nodes under you</h6>
<?php
	foreach($NodeUsers as $node){
?>
<a href='/users/message/<?=$user_id?>/<?=$node['_id']?>' class='label label-warning' rel='tooltip' title='Thank <?=$node['firstname']?>' ><?=$node['firstname']?></a>,
<?php
	}
}
?>
<hr>

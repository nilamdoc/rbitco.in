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
?>
	<tr>
		<td><?=$a['date']?></td>
		<td><?=number_format($a['amount'],7)?></td>		
		<td><?=$a['description']?></td>				
		<td><?=$a['refer']?></td>						
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
		print_r($parent['firstname']);	
		echo ", ";
	}
}
if (count($NodeUsers)>0){
?>
<h6>You have <?php print_r($countNodes)?> child nodes under you</h6>
<?php
	foreach($NodeUsers as $node){
		print_r($node['firstname']);	
		echo ", ";	
		print_r($node['user_id']);			
	}
}
?>
<hr>

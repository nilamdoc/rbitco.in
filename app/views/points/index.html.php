<h4>Points explained</h4>
<div class="row">
	<div class="span6">
	<table class="table table-condensed table-striped table-bordered" style="background-color:white;width:50% ">
			<thead>
				<tr>
				<th colspan="3" style="text-align:center;background-color:#AEC99A">Your points</th>
				</tr>
				<tr>
					<th style="text-align:center ">Gold</th>
					<th style="text-align:center ">Silver</th>
					<th style="text-align:center ">Bronze</th>
				</tr>
				<tbody>
					<td style="text-align:center "><span class="label label-warning"><?=$pointsGold?></span></td>				
					<td style="text-align:center "><span class="label"><?=$pointsSilver?></span></td> 
					<td style="text-align:center "><span class="label label-important"><?=$pointsBronze?></span></td>					
				</tbody>
			</table>
			<h4>Point calculations</h4>
		<p class="label label-important">Bronze points</p>
		<p>You can earn bronze points by messaging different users and replying their messages. They are represented by <span class="label label-important">1</span>. </p>
		<div><p class="label ">Silver points</p>
		<p>You earn silver points when you order a vanity address or signin. They are represented by <span class="label">1</span>.</p>
		<table class="table table-condensed table-striped table-bordered" style="background-color:white" >
			<thead>
				<tr>
					<th>Action</th>
					<th>Points</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Order a vanity</td>
					<td>Length of vanity</td>
				</tr>
				<tr>
					<td>Signin > 100 a month</td>
					<td>1</td>
				</tr>
				<tr>
					<td>Signin consicutive 100 days</td>
					<td>5</td>
				</tr>
				<tr>
					<td>Signin consicutive 1 year</td>
					<td>10</td>
				</tr>				
			</tbody>
		</table>
		</div>
		<p class="label label-warning">Gold points</p>		
		<p>You earn Gold  when you deposit in the wallet. They are represented by <span class="label label-warning">1</span>.</p>
		<p>You can earn interest on your wallet on daily basis. Interest will be shown on your accounts page daily.</p>
		<table class="table table-condensed table-striped table-bordered span3" style="background-color:white" >
			<thead>
				<tr>
					<th>Deposit BTC</th>
					<th>Rate of interest<br>
					per annum
					</th>
				</tr>
			</thead>
			<tbody>

<?php
$i = 0;
foreach ($payments as $p){
	$Amount0 = number_format($p['interest']['0']['amount'],6);
	$Rate0 = $p['interest']['0']['rate'];	
	$Amount1 = number_format($p['interest']['1']['amount'],6);
	$Rate1 = $p['interest']['1']['rate'];	
	$Amount2 = number_format($p['interest']['2']['amount'],6);
	$Rate2 = $p['interest']['2']['rate'];	
	$Amount3 = number_format($p['interest']['3']['amount'],6);
	$Rate3 = $p['interest']['3']['rate'];	
	$Amount4 = number_format($p['interest']['4']['amount'],6);
	$Rate4 = $p['interest']['4']['rate'];	
	$Amount5 = number_format($p['interest']['5']['amount'],6);
	$Rate5 = $p['interest']['5']['rate'];	
}
?>
				<tr>
					<td>> <?=$Amount0?></td>
					<td><?=$Rate0?>% </td>					
				</tr>
				<tr>
					<td>> <?=$Amount1?></td>
					<td><?=$Rate1?>% </td>					
				</tr>
				<tr>
					<td>> <?=$Amount2?></td>
					<td><?=$Rate2?>% </td>					
				</tr>
				<tr>
					<td>> <?=$Amount3?></td>
					<td><?=$Rate3?>% </td>					
				</tr>
				<tr>
					<td>> <?=$Amount4?></td>
					<td><?=$Rate4?>% </td>					
				</tr>
				<tr>
					<td>> <?=$Amount5?></td>
					<td><?=$Rate5?>% </td>					
				</tr>
			</tbody>
		</table>
	</div>
	<div class="span3 pull-right">
		<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
			<thead>
				<tr>
				<th colspan="4" style="text-align:center;background-color:#AEC99A">Leader Board</th>
				</tr>
				<tr>
					<th>Name</th>
					<th style="text-align:center ">Gold</th>					
					<th style="text-align:center ">Silver</th>
					<th style="text-align:center ">Bronze</th>
				</tr>
				<tbody>
				<?php
					foreach($countPointsAll as $result){
				?>	
					<tr>
						<td><?=$result['name']?></td>
						<td style="text-align:center "><span class="label label-warning tooltip-x"  rel='tooltip' title='<?=$result['Gold__points'];?> deposits to wallet'><?php if($result['Gold__points']!=""){echo $result['Gold__points'];}else{echo "0";}?></span></td>						
						<td style="text-align:center "><span class="label tooltip-x" rel='tooltip' title='<?=$result['Silver__points'];?> vanity addresses' ><?php if($result['Silver__points']!=""){echo $result['Silver__points'];}else{echo "0";}?></span></td>						
						<td style="text-align:center "><span class="label label-important tooltip-x" rel='tooltip' title='<?=$result['Bronze__points'];?> messages to friends' ><?php if($result['Bronze__points']!=""){echo $result['Bronze__points'];}else{echo "0";}?></td>												
					</tr>
				<?php
				}
				?>
				</tbody>
			</thead>
		</table>
	</div>
</div>
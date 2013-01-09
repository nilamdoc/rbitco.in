<h4>Points explained</h4>
<div class="row">
	<div class="span6">
	<table class="table table-condensed table-striped table-bordered" style="background-color:white;width:50% ">
			<thead>
				<tr>
				<th colspan="3" style="text-align:center;background-color:#AEC99A">Your points</th>
				</tr>
				<tr>
					<th style="text-align:center ">Black Diamond</th>
					<th style="text-align:center ">Silver</th>
					<th style="text-align:center ">Bronze</th>
				</tr>
				<tbody>
					<td style="text-align:center "><span class="label label-inverse"><?=$pointsBlack?></span></td>				
					<td style="text-align:center "><span class="label"><?=$pointsSilver?></span></td>
					<td style="text-align:center "><span class="label label-warning"><?=$pointsBronze?></span></td>					
				</tbody>
			</table>
			<h4>Point calculations</h4>
		<p class="label label-warning">Bronze points</p>
		<p>You can earn bronze points by messaging different users and replying their messages. They are represented by <span class="label label-warning">1</span>. </p>
		<p class="label ">Silver points</p>
		<p>You earn silver points when you order a vanity address. They are represented by <span class="label">1</span>.</p>
		<p class="label label-inverse">Black Diamond points</p>		
		<p>You earn black diamond when you deposit in the wallet. They are represented by <span class="label label-inverse">1</span>.</p>
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
				<tr>
					<td>< 100 </td>
					<td>0% </td>					
				</tr>
				<tr>
					<td>101 - 250 </td>
					<td>1% </td>					
				</tr>
				<tr>
					<td>251 - 500 </td>
					<td>2% </td>					
				</tr>
				<tr>
					<td>501 - 1,000 </td>
					<td>3% </td>					
				</tr>
				<tr>
					<td>1001 or more </td>
					<td>4% </td>					
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
					<th style="text-align:center ">Black<br>Diamond</th>					
					<th style="text-align:center ">Silver</th>
					<th style="text-align:center ">Bronze</th>
				</tr>
				<tbody>
				<?php
					foreach($countPointsAll['points']['result'] as $result){
				?>	
					<tr>
						<td><?=$result['_id']['name']?></td>
						<td style="text-align:center "><span class="label label-inverse"><?php if($result['_id']['type']=='Black'){echo $result['points'];}else{echo "0";}?></span></td>						
						<td style="text-align:center "><span class="label"><?php if($result['_id']['type']=='Silver'){echo $result['points'];}else{echo "0";}?></span></td>						
						<td style="text-align:center "><span class="label label-warning"><?php if($result['_id']['type']=='Bronze'){echo $result['points'];}else{echo "0";}?></td>												
					</tr>
				<?php
				}
				?>
				</tbody>
			</thead>
		</table>
	</div>
</div>
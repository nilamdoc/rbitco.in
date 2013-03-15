<h4>Hi <?=$user['firstname']?>,</h4>
<div class="row">
	<div class="span3">
		<div class="well">
			<h4>Order details</h4>
			<hr class="soften">
			<h4>Product: <?=$product?></h4>
			<h5>Value: <?=$value?> <?=$currency?></h5>
			<h5>BTC: <?=$addBTC?> BTC</h5>
			<h5>Payment to: <?=$details['username']?></h5>
		</div>
	</div>
	<div class="span6">
		<div class="well">
			<?php
			if($wrong=="Yes"){
			?><a href="<?=$referrer?>">Something went wrong! Go back to the merchant!</a>
			<?php	
			}else{
			?>
			<h4>Current Balance</h4>
			Your current balance is <strong><?=number_format($sumAccounts['account']['result'][0]['amount'],8)?> BTC</strong>.<br><br>
<br>
			<?php 
				if(number_format($sumAccounts['account']['result'][0]['amount'],8)>=$addBTC){
			?>
				<a href="/payment/make" class="btn btn-success">Make payment</a>
			<?php
				}else{
			?>
				You do not have enough funds to pay to the merchant. You can add funds to your account by clicking <a href="/users/addfunds" target="_blank" class="label">here</a>.<br><br>
				Once you have completed adding funds to your account just refresh the page and make the payment to the merchant.<br>
<br>
			<?php							
				}
			?>
			
			<?php
			}
			?>
			<a href="<?=$referrer?>">Cancel payment! Go back to the merchant!</a>
		</div>
	</div>
</div>
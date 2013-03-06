<h4>Add funds</h4>
<h5>Method 1:</h5>
<p>We recommand you to add funds to any of your wallet addresses. </p>
<p>Wallet addresses:<br>
<strong>
<?php
foreach($wallet['wallet']['address'] as $address){
	echo '<code>'.$address."</code><br>";
}
?></strong>
</p>

<h5>Method 2:</h5>
<?php $inr = round($tickers['ticker']['high']*$tickers['INR'],0)?>
<?php $usd = round($tickers['ticker']['high'],2)?>
<p>Direct deposit of cash / cheque to our <a href="/Articles/payment">bank</a> account. We will convert to BTC and update your account.</p>
<div style="background-color:#FFFFFF;padding:10px ">
<p>I, <?=$user['firstname']?> <?=$user['lastname']?>, username: <?=$user['username']?> would like to add BTC to my account at the site rbitco.in.</p>
<p>I am submitting this form to track back my order.</p>
<?=$this->form->create('',array('url'=>'/users/addfunds')); ?>
<?=$this->form->field('btc_amount', array('label'=>'Add BTC', 'placeholder'=>'10','class'=>'span2', 'onBlur'=>'changeMtGox(this.value);'));?>
<input class="span2" size="16" type="text" name="bid_inr_amount" id="bidinrAmount" value="<?=$inr?>" readonly="readonly"> INR or 
<input class="span2" size="16" type="text" name="bid_usd_amount" id="bidusdAmount" value="<?=$usd?>" readonly="readonly"> USD <br>
<?=$this->form->hidden('datetime.date',array('value'=>gmdate('Y-m-d',time()))); ?>
<?=$this->form->hidden('datetime.time',array('value'=>gmdate('H:i:s',time()))); ?>
<?=$this->form->hidden('user_id',array('value'=>$user['_id'])); ?>
<?=$this->form->hidden('username',array('value'=>$user['username'])); ?>
<?=$this->form->hidden('complete',array('value'=>'N')); ?>
<?=$this->form->hidden('type',array('value'=>'Add BTC')); ?>
<?=$this->form->submit('Add BTC to my account!',array('class'=>'btn btn-primary','onclick'=>'return placeOrder("INR");')); ?>
<?=$this->form->end(); ?>
<table width="90%">
	<tr>
		<th colspan="4">Checkout directly with MtGox</th>
	</tr>
	<tr>
		<td><span class="mtgox" data-id="ec016efb-00eb-4968-ae9a-c843c21dbe14" data-amount="1" data-currency="BTC"><a href="https://payment.mtgox.com/ec016efb-00eb-4968-ae9a-c843c21dbe14"><img src="https://payment.mtgox.com/img/mtgox-checkout.png" border="0" /></a></span>
			<![if !IE]><script type="text/javascript" src="https://payment.mtgox.com/js/button.min.js"></script><![endif]>
		</td>
		<td><span class="mtgox" data-id="af230faa-0a28-4c17-b3ce-71b56bed3e4b" data-amount="2" data-currency="BTC"><a href="https://payment.mtgox.com/af230faa-0a28-4c17-b3ce-71b56bed3e4b"><img src="https://payment.mtgox.com/img/mtgox-checkout.png" border="0" /></a></span>
			<![if !IE]><script type="text/javascript" src="https://payment.mtgox.com/js/button.min.js"></script><![endif]>
		</td>
		<td><span class="mtgox" data-id="34a8037c-e294-4f2f-a1fa-bce8da3d9338" data-amount="5" data-currency="BTC"><a href="https://payment.mtgox.com/34a8037c-e294-4f2f-a1fa-bce8da3d9338"><img src="https://payment.mtgox.com/img/mtgox-checkout.png" border="0" /></a></span>
			<![if !IE]><script type="text/javascript" src="https://payment.mtgox.com/js/button.min.js"></script><![endif]>
		</td>
		<td><span class="mtgox" data-id="2104dfc2-be51-4c08-b909-f8797096a495" data-amount="10" data-currency="BTC"><a href="https://payment.mtgox.com/2104dfc2-be51-4c08-b909-f8797096a495"><img src="https://payment.mtgox.com/img/mtgox-checkout.png" border="0" /></a></span>
			<![if !IE]><script type="text/javascript" src="https://payment.mtgox.com/js/button.min.js"></script><![endif]>
		</td>
	</tr>
</table>

<p> After you submit this form, you will receive an email for making payments to us for adding the BTC. We will add BTC within 12 hours, we get the funds in our account. Please also read this for makeing the payment to our <a href="/Articles/payment" target="_blank">bank</a></p>
</div>
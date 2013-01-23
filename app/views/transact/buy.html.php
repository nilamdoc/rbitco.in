<h4>Buy BTC:</h4>
<?php $inr = round($tickers['ticker']['high']*$tickers['INR']*.95,0)?>
<?php $usd = round($tickers['ticker']['high']*.95,2)?>
BTC balance in the wallet is <?=number_format($wallet['wallet']['balance'],8)?> (<?= ucwords($word)?> BTC)
<div style="background-color:#fff;padding-top:10px;border-top:1px solid;border-bottom:1px solid  ">
	<div class="tabbable"> <!-- Only required for left/right tabs -->
		<ul class="nav nav-tabs">
			<li class="active"><a href="#tab1" data-toggle="tab">INR</a></li>
			<li><a href="#tab2" data-toggle="tab">USD</a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<div style="padding:10px ">
				
<?=$this->form->create('',array('url'=>'/transact/buy')); ?>
<p>I want to buy</p>
    <div class="input-append">
		<input class="span2" size="16" type="text" name="btc_amount" id="btcAmount" placeholder="10.01">
	<span class="add-on">BTC</span>
    </div>
<p>My bid price per BTC is </p>	
    <div class="input-append">
		<input class="span2" size="16" type="text" name="inr_amount" id="inrAmount" value="<?=$inr?>">
	<span class="add-on">INR</span>
    </div>
<br>
<?=$this->form->submit('Place INR bid',array('class'=>'btn btn-primary','onclick'=>'return placeBid();')); ?>
<?=$this->form->end(); ?>
				</div>
			</div>
			<div class="tab-pane" id="tab2">
				<div style="padding:10px ">
			
<?=$this->form->create('',array('url'=>'/transact/buy')); ?>
<p>I want to buy</p>
    <div class="input-append">
		<input class="span2" size="16" type="text" name="btc_amount" id="btcAmount" placeholder="10.01">
	<span class="add-on">BTC</span>
    </div>
<p>My bid price per BTC is </p>	
    <div class="input-append">
		<input class="span2" size="16" type="text" name="usd_amount" id="usdAmount" value="<?=$usd?>">
	<span class="add-on">USD</span>
    </div>
<br>
<?=$this->form->submit('Place USD bid',array('class'=>'btn btn-primary','onclick'=>'return placeBid();')); ?>
<?=$this->form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
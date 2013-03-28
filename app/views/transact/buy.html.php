<h4>Buy BTC: 
<a href="/transact" class="label label-success">Check sell bids</a>
<a href="/transact/sell" class="label label-warning">Ooops! I want to sell</a>
</h4>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<h5>Buying Bitcoins:</h5>
<p>** DISCLAIMER: There are new Bitcoin exchanges, services, and businesses coming online constantly. 
We here at rBitcoin do not endorse any of these sites in any way - we are simply providing the links to sites that 
claim they will sell you Bitcoins - you should research all entities you transact business with as much as possible. 
Remember - it's the wild, wild west out there.</p>
</div>
<?php $inr = round($tickers['ticker']['high']*$tickers['INR']*1.1,0)?>
<?php $usd = round($tickers['ticker']['high']*1.1,2)?>

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
		<input class="span2" size="16" type="text" name="btc_amount" id="btcinrAmount" placeholder="10.01">
	<span class="add-on">BTC</span>
    </div>
<p>My bid price per BTC is </p>	
    <div class="input-append">
		<input class="span2" size="16" type="text" name="bid_amount" id="bidinrAmount" value="<?=$inr?>" readonly="readonly">
	<span class="add-on">INR</span>
    </div>
<br>
<?=$this->form->hidden('currency',array('value'=>'INR')); ?>
<?=$this->form->hidden('datetime.date',array('value'=>gmdate('Y-m-d',time()))); ?>
<?=$this->form->hidden('datetime.time',array('value'=>gmdate('H:i:s',time()))); ?>
<?=$this->form->hidden('user_id',array('value'=>$user['_id'])); ?>
<?=$this->form->hidden('username',array('value'=>$user['username'])); ?>
<?=$this->form->hidden('complete',array('value'=>'N')); ?>
<?=$this->form->hidden('type',array('value'=>'Buy')); ?>
<?=$this->form->submit('Place INR bid',array('class'=>'btn btn-primary','onclick'=>'return placeBid("INR");')); ?>
<?=$this->form->end(); ?>
				</div>
			</div>
			<div class="tab-pane" id="tab2">
				<div style="padding:10px ">
			
<?=$this->form->create('',array('url'=>'/transact/buy')); ?>
<p>I want to buy</p>
    <div class="input-append">
		<input class="span2" size="16" type="text" name="btc_amount" id="btcusdAmount" placeholder="10.01">
	<span class="add-on">BTC</span>
    </div>
<p>My bid price per BTC is </p>	
    <div class="input-append">
		<input class="span2" size="16" type="text" name="bid_amount" id="bidusdAmount" value="<?=$usd?>">
	<span class="add-on">USD</span>
    </div>
<br>
<?=$this->form->hidden('currency',array('value'=>'USD')); ?>
<?=$this->form->hidden('datetime.date',array('value'=>gmdate('Y-m-d',time()))); ?>
<?=$this->form->hidden('datetime.time',array('value'=>gmdate('H:i:s',time()))); ?>
<?=$this->form->hidden('user_id',array('value'=>$user['_id'])); ?>
<?=$this->form->hidden('complete',array('value'=>'N')); ?>
<?=$this->form->hidden('username',array('value'=>$user['username'])); ?>
<?=$this->form->hidden('type',array('value'=>'Buy')); ?>
<?=$this->form->submit('Place USD bid',array('class'=>'btn btn-primary','onclick'=>'return placeBid("USD");')); ?>
<?=$this->form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if(isset($deals)){?>
<h5>You have already placed a transaction for buy/sell, once this transaction gets complete, you can add another transaction. </h5>
<table class="table table-condensed table-striped table-bordered" style="background-color:white;width:70% ">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Date</th>
			<th>Amount</th>
			<th>Bid</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php

foreach ($deals as $deal){?>
	<tr>
		<td><a href="/transact/delete/<?=$deal['_id']?>" class="tooltip-x " rel='tooltip' title='Remove this bid'><i class="icon icon-remove"></i></a></td>
		<td><?=$deal['datetime']['date']?> <?=$deal['datetime']['time']?></td>
		<td><?=$deal['btc_amount']?> BTC</td>		
		<td><?=$deal['bid_amount']?> <?=$deal['currency']?></td>				
		<td><?=$deal['type']?> BTC</td>
	</tr>
<?php
	}

?>
</tbody>
</table>
<?php } ?>
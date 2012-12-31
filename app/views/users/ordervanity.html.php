<?php
use lithium\storage\Session;
$user = Session::read('member');
?>
<h4>Order Vanity Bitcoin address:</h4>
<div class="row">
	<div class="span5">
<?=$this->form->create("",array('url'=>'/users/confirmvanity/')); ?>
<?=$this->form->field('vanity_type', array('label'=>'Vanity Type','value'=>$style,'readonly'=>'readonly')); ?>
<?=$this->form->field('vanity_length', array('label'=>'Vanity Length','value'=>$length,'readonly'=>'readonly')); ?>
<?=$this->form->field('email', array('label'=>'Your email','value'=>$user['email'])); ?>
<?=$this->form->field('vanity_pattern', array('label'=>'Your pattern','placeholder'=>substr('CoolBitCoin',0,($length)),'maxlength'=>$length)); ?>
<?php 
foreach($sendmoney as $s){
	if($style=="Start"){
		$payment = 'payment of ' . $s['start'] . ' BTC to';
	}
	if($style=="Regex"){	
		$payment = 'payment of '. $s['regex'].' BTC to';
	}
}
?>
<?=$this->form->field('vanity_payment', array('label'=>'Send '.$payment,'value'=>'1BitCoinpjWQKnrR3GXH1awtRjJDpCGU15','readonly'=>'readonly','class'=>'span4')); ?>
<?=$this->form->field('vanity_payment_from', array('label'=>'From address:','value'=>'Your bitcoin address','class'=>'span4')); ?>
<?=$this->form->submit('Confirm order',array('class'=>'btn btn-primary')); ?>
&nbsp;<a href="/users/vanity" class="btn">Modify</a>
</p>
<?=$this->form->end(); ?>
	</div>
	<div class="span4">
<p>Once you confirm the order, send a <strong><?=$payment?></strong> the address: <strong>1BitCoinpjWQKnrR3GXH1awtRjJDpCGU15</strong>.</p>
<p>Your can track your payment receipt <a href="/network/address/">here</a>.</p>
<p>On receipt of your payment:
<ul>
	<li>If you are a registered user, we will add the new address to your wallet.</li>
	<li>If you are not a registered user we will send you the private key by a secure email.</li>
</ul>
<p>Scan and send! QR Code for <strong>1BitCoinpjWQKnrR3GXH1awtRjJDpCGU15</strong>
</p>
	<?php
use li3_qrcode\extensions\action\QRcode;
$qrcode = new QRcode();
$qrcode->png('1BitCoinpjWQKnrR3GXH1awtRjJDpCGU15', QR_OUTPUT_DIR.'1BitCoinpjWQKnrR3GXH1awtRjJDpCGU15.png', 'H', 7, 2);
	?>
	<img src="<?=QR_OUTPUT_RELATIVE_DIR?>/1BitCoinpjWQKnrR3GXH1awtRjJDpCGU15.png">
	</div>
</div>
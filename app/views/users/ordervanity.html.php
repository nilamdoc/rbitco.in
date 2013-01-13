<?php
use lithium\storage\Session;
$user = Session::read('member');
$id = $user['_id'];

?>
<h4>Order Vanity Bitcoin address:</h4>
<?php if($id==""){?>
<p><strong>You have not signed in or registered!</strong></p>
<?php }?>
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
		$amount = $s['start'];
	}
	if($style=="Regex"){	
		$payment = 'payment of '. $s['regex'].' BTC to';
		$amount = $s['regex'];
	}
}
$vanityPayment = $address;
?>
<?=$this->form->field('vanity_payment', array('label'=>'Send '.$payment,'value'=>$vanityPayment,'readonly'=>'readonly','class'=>'span4')); ?>
<?=$this->form->field('vanity_payment_from', array('label'=>'From address:','placeholder'=>'Your bitcoin address','class'=>'span4')); ?>
<?=$this->form->hidden('vanity_amount',array('value'=>$amount));?>
<?=$this->form->hidden('datetime.date',array('value'=>gmdate('Y-m-d',time())));?>
<?=$this->form->hidden('datetime.time',array('value'=>gmdate('H:i:s',time())));?>
<?=$this->form->hidden('order_complete',array('value'=>'N'));?>
<?=$this->form->hidden('user_id',array('value'=>$id));?>
<?=$this->form->submit('Confirm order',array('class'=>'btn btn-primary','onclick'=>'return ConfirmVainty('.$length.');')); ?>
&nbsp;<a href="/users/vanity" class="btn">Modify</a>
</p>
<?=$this->form->end(); ?>
	</div>
	<div class="span4">
<h5>Steps to get Vanity</h5>
<ul>
	<li>You confirm the order on this page.</li>
	<li>We will send you a confirmation email.</li>
	<li>You make the payment of <strong><?=$payment?></strong> the address: <strong><?=$vanityPayment?></strong>. </li>
	<li>System will start generating the vanity address.</li>
	<li>On completion, system will send an email to you with the address and private key.</li>
	<li>You can then use the private key to add the vanity address to your wallet on this site or any other wallet.</li>
</ul>
<p>Scan and send! QR Code for <strong><?=$vanityPayment?></strong>
</p>
	<?php
use li3_qrcode\extensions\action\QRcode;
$qrcode = new QRcode();
$qrcode->png($vanityPayment, QR_OUTPUT_DIR.$vanityPayment.'.png', 'H', 7, 2);
	?>
	<img src="<?=QR_OUTPUT_RELATIVE_DIR?>/<?=$vanityPayment?>.png">
	</div>
</div>
<div class="well"><h1>Real Bitcoin (rbitco.in)</h1>
<p>This portal is being discontinued from 31st January 2014. Since 9th January 2013, we were sharing bitcoin information for Indian customers. We also had international customer registration from different countries. All users who registered with their email, were verified. Some users had deposited bitcoins from sites offering them, and also withdraw bitcoins when the balance was above 0.1 BTC. We have still users who have their BTC with us.</p>
<p>We would like to return all the coins to all the users who have a balance still deposited with us.</p>
<p>Please make sure you follow the <a href="https://en.bitcoin.it/wiki/How_to_import_private_keys" target="_blank">instructions</a> and restore the coins in your personal wallet using the private keys. Your wallet can be a desktop client or any other web hosted client.</p>
<?php
if($data['address']){
	$address = $data['address'];
}else{
	$address = "NoAddress";
}
?>
<?=$this->form->create(null); ?>
<?=$this->form->field('username', array('label'=>'Username')); ?>
<?=$this->form->field('address', array('type'=>'hidden','value'=>$address)); ?>
<?=$this->form->field('email', array('label'=>'Email')); ?>
<?=$this->form->submit('Show Private Key' ,array('class'=>'btn btn-primary','onclick'=>'return ShowPrivKey();')); ?>
<?=$this->form->end(); ?>
	<div id="Error" class="alert"><?=$msg?></div>
</div>
<div>
<p>Article on Bitcoin Wiki to <a href="https://en.bitcoin.it/wiki/How_to_import_private_keys" target="_blank">Import Private Keys</a></p>
</div>
<script>

</script>
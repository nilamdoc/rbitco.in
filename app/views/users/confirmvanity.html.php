<h4>Confirm Vanity</h4>
<p>You have ordered a vanity address "<?=$data['vanity_pattern']?>" for <?=$data['vanity_type']?>.</p>

<p>Please make the payment of <strong><?=$data['vanity_amount']?></strong> to the address <strong><?=$data['vanity_payment']?></strong>.</p>

<p>Please make sure you make a payment from this address: <strong><?=$data['vanity_payment_from']?></strong>, if you do not send the payment within 7 days of this order, you order will be cancelled.</p>

<p>Once we recive at least 6 confirmations on your order the system will start generating your vanity address.</p>

<p>On completion of the generation, the system will send you a file having the pattern, address and private key.</p>

<p>You the private key to add your vanity address to your wallet on rbitco.in or any other wallet.</p>

<p>Thank you for placing an order with us.</p>


<h5>Security: </h5>
<p>This email and vanity generation is automatic, no person other than yourself will see the privatekey. Please do not share the private key with anyone.</p>

<h5>Next steps:</h5>
<ul>
	<li>We will send you a confirmation email.</li>
	<li>You make the payment of <strong><?=$data['vanity_amount']?></strong> the address: <strong><?=$data['vanity_payment']?></strong>. </li>
	<li>System will start generating the vanity address.</li>
	<li>On completion, system will send an email to you with the address and private key.</li>
	<li>You can then use the private key to add the vanity address to your wallet on this site or any other wallet.</li>
</ul>
<a href="/users/vanity" class="btn btn-primary">Order another vanity address</a>
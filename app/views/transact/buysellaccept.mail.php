<p>Hi <?=$data['username']?>, </p>
<h5>Your order number is: RB<?=substr($data['accept']['datetime']['time'],4,1)?>00<?=substr($data['accept']['datetime']['time'],6,2)?> </h5>
<p>You have accepted to <?=$params[10]?> <?=$params[5]?> BTC at <?=$params[6]?> <?=$params[7]?>. 
Your total payment due is <?=$params[9]?>.<?=substr($data['accept']['datetime']['time'],6,2)?></p>

<p>Your confirmation is very important. </p>
<?php if($params[10]=="Buy"){?>
<p>As this is a BUY-BTC order you will have to deposit <strong><?=$params[7]?> <?=round($params[5]*$params[6],0)?>.
<?=substr($data['accept']['datetime']['time'],6,2)?></strong> as per the instructions below:</p>
<p>As this is a trade between you and the seller, we need to escrow the amount before we complete the deal.</p>

<h4>Important instructions </h4>
<h4>How will we know it's you who made the deposit?</h4>
<p>Please round the amount of your order up to the next higher whole amount, then add the last two digits of the Invoice/Order Number to the amount, as cents. This unique deposit amount is how we can tell it was you who made the deposit.</p>
    <p>Your order total is: <?=$params[7]?> <?=round($params[5]*$params[6],2)?> Round it up to: <?=$data['currency']?>  <?=round($params[5]*$params[6],0)?></p>
    <p>if your Invoice/Order Number is: RB<?=substr($data['accept']['datetime']['time'],4,1)?>00<?=substr($data['accept']['datetime']['time'],6,2)?></p>
    <p>Add <?=$params[7]?>  0.<?=substr($data['accept']['datetime']['time'],6,2)?> to the amount... ( the last two digits of your Order Number is <?=substr($data['accept']['datetime']['time'],6,2)?> )</p>
    <p>Making the final exact amount to deposit: <?=$params[7]?> <?=round($params[5]*$params[6],0)?>.<?=substr($data['accept']['datetime']['time'],6,2)?> </p>
</div>	
<p>You will make the payment from your bank to the details given below.</p>
<table style="background-color:white;width:70% ">
	<tr>
		<td>Bank Name:</td>
		<td>ICICI Bank</td>
	</tr>
	<tr>
		<td>Branch Name:</td>
		<td>JMC House</td>
	</tr>
	<tr>
		<td>Branch Address:</td>
		<td>JMC HOUSE, OPP. PARIMAL GARDENS, OFF. C.G. ROAD</td>
	</tr>
	<tr>
		<td>Pin/Zip code:</td>
		<td>380 006</td>
	</tr>
	<tr>
		<td>Branch City:</td>
		<td>Ahmedabad</td>
	</tr>
	<tr>
		<td>Swift Code:</td>
		<td>ICICINBB024</td>
	</tr>
	<tr>
		<td>Branch Country:</td>
		<td>India IN</td>
	</tr>
	<tr>
		<td>Account Name:</td>
		<td>Hitarth Consultants</td>
	</tr>
	<tr>
		<td>Account Number:</td>
		<td>002405010974</td>
	</tr>
	<tr>
		<td>MICR code:</td>
		<td>380229002</td>
	</tr>	
</table>
<?php }else{
?>
<p>As this is a SELL-BTC order you will have to deposit <?=$params[5]?> BTC in your address:
<ul>
 <?php foreach($wallet['wallet']['address'] as $a){
 	echo "<li>".$a."</li>";
 }?>
</ul> 
</p>
<p>Once your sell order is responded by a user, on receipt of payment, your 
account will be debited for the BTC and credited for equivalent of <strong><?=$params[7]?> <?=round($params[5]*$params[6],0)?></strong></p>

<p>As this is a trade between you and the buyer, we need to escrow the BTC before we complete the deal.</p>
<?php }?>
<p>Thank you for doing business with us.<br>
Support rbitco.in</p>
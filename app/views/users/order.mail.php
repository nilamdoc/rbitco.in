<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://rbitco.in/img/rBitco.in.gif" alt="rBitcoin">
</div>
<p>Hi <?=$data['username']?>, </p>
<h5>Your order number is: RB<?=substr($data['datetime']['time'],4,1)?>00<?=substr($data['datetime']['time'],6,2)?> </h5>
<p>You have placed an order for "<strong><?=$data['type']?></strong>" with us for <strong><?=$data['btc_amount']?> BTC</strong>
 at <?=$data['bid_inr_amount']?> INR or <?=$data['bid_usd_amount']?> USD.</p>
 
<p>Once you complete the payment to rBitcoin as per the instructions below, we will transfer the BTC to your account within 12 hours.</p>

<h4>Important instructions </h4>
<h4>How will we know it's you who made the deposit?</h4>
<p>Please round the amount of your order up to the next higher whole amount, then add the last two digits of the Invoice/Order Number to the amount, as cents. This unique deposit amount is how we can tell it was you who made the deposit.</p>
    <p>Your order total is: INR <?=round($data['btc_amount']*$data['bid_inr_amount'],2)?> 
	Round it up to: INR  <?=round($data['btc_inr_amount']*$data['bid_amount'],0)?></p>
	<p>Your order total is: USD <?=round($data['btc_amount']*$data['bid_usd_amount'],2)?> 
	Round it up to: USD  <?=round($data['btc_usd_amount']*$data['bid_amount'],0)?></p>
	
    <p>if your Invoice/Order Number is: RB<?=substr($data['datetime']['time'],4,1)?>00<?=substr($data['datetime']['time'],6,2)?></p>
    <p>Add INR or USD  0.<?=substr($data['datetime']['time'],6,2)?> to the amount... ( the last two digits of your Order Number is <?=substr($data['datetime']['time'],6,2)?> )</p>
    <p>Making the final exact amount to deposit: INR <?=round($data['btc_amount']*$data['bid_inr_amount'],0)?>.<?=substr($data['datetime']['time'],6,2)?>
	or USD <?=round($data['btc_amount']*$data['bid_usd_amount'],0)?>.<?=substr($data['datetime']['time'],6,2)?> </p>
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
<p>Thank you for doing business with us.<br>
Support rbitco.in</p>

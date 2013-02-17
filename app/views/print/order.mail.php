<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://rbitco.in/img/rBitco.in.gif" alt="rBitcoin">
</div>
<p>Hi <?=$data['username']?>,</p>
<p>You have orderd paper BTC print from us through 
<?php if($data['print']==1){
	echo " snail mail.";
}else{
	echo " email.";
}
?>
</p>
<p>Please make a payment of <?=$data['total']?> BTC to <a href="bitcoin:<?=$data['payment_address']?>"><?=$data['payment_address']?></a>. </p>
<p>As soon as we receive the above payment we shall process your order and deliver to you the PDFs through email <?=$data['email']?>.</p>

<p>Support,<br>
rBitco.in</p>

<p>Note: The entire process of generating of print order is done without any human interference.</p>
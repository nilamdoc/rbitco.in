<h4>Create button</h4>
<p>We have designed pay with bitcoin button very simple.</p>

<form action="/merchant/create" method="post">
Select currency:
<select class="span2" name="currency" id="currency">
	<option value="INR">INR</option>
	<option value="BTC">BTC</option>
	<option value="USD">USD</option>
</select><br>
Select amount:&nbsp;&nbsp;
<input type="text" value="100" name="amount" id="amount" class="span2">
<br>
Product code:&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" value="ABC" name="product" id="product" class="span2"> (optional)<br>
Success URL: &nbsp;&nbsp;
<input type="text" value="" name="success_url" id="success_url" class="span4" placeholder="http://domain.com/success"><br>

Cancel URL: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" value="" name="cancel_url" id="cancel_url" class="span4" placeholder="http://domain.com/cancel"><br>
<input type="submit" value="Create" class="btn btn-primary" onClick="return checkURL();">
</form>
<?php 
if ($_POST['amount']){
?>
<pre>
&lt;span class="rbitcoin" data-id="<?=$key_secret['key']?>" data-amount="<?=$_POST['amount']?>" data-currency="<?=$_POST['currency']?>" data-product="<?=$_POST['product']?>"&gt;
 &lt;a href="https://<?=$_SERVER['HTTP_HOST']?>/payment/send/<?=$key_secret['key']?>">
  &lt;img src="https://<?=$_SERVER['HTTP_HOST']?>/img/rbitcoin-checkout.png" border="0" /&gt;
 &lt;/a&gt;
&lt;/span&gt;
</pre>
<span class="rbitcoin" data-id="<?=$key_secret['key']?>" data-amount="<?=$_POST['amount']?>" data-currency="<?=$_POST['currency']?>" data-product="<?=$_POST['product']?>">
 <a href="https://<?=$_SERVER['HTTP_HOST']?>/payment/send/<?=$key_secret['key']?>">
  <img src="https://<?=$_SERVER['HTTP_HOST']?>/img/rbitcoin-checkout.png" border="0" />
 </a>
</span>
<![if !IE]><script type="text/javascript" src="https://payment.mtgox.com/js/button.min.js"></script><![endif]>
<?php
}
?>
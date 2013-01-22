<h4>Deposit:</h4>
You can add to this wallet:
<ul>
	<li>Direct payment to the Bitcoin address</li>
	<li>Get free bitcoins from other websites</li>
	<li>Website integration</li>
</ul>
<p>Wallet addresses:<br>
<strong>
<?php
foreach($wallet['wallet']['address'] as $address){
	echo $address."<br>";
}
?></strong>
</p>

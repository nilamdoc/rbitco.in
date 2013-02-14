<h4>Print paper currency</h4>
<h5>Uses:</h5>
<ol>
	<li><strong>Security</strong>: As this is an offline virtual currency, it is very safe from the hackers of the internet world.</li>
	<li><strong>Gift</strong>: You can gift these bitcoins to friends, children, grandchildren and make them aware of this new phenomena. Also make their world secure!</li>
	<li><strong>Collectibles</strong>: Use them as collectibles as you collect stamps...</li>
	<li><strong>Transact</strong>: Many newbies want bitcoins, but they do not trust it unless they see it and feel it. This is one of the best options for traders who sell BTC off cafes, meeting points. They can show them and give them to the buyer for cash!</li>
	<li><strong>Denominations</strong>: You wallet can be broken to different denominations of safe currency. If you have 100BTC, you can divide them into:
		<ul>
			<li>1 x 50 BTC</li>
			<li>1 x 20 BTC</li>
			<li>1 x 10 BTC</li>
			<li>1 x 5 BTC</li>
			<li>1 x 2 BTC</li>
			<li>5 x 1 BTC</li>
			<li>10 x 0.1 BTC</li>
			<li>20 x 0.2 BTC</li>
			<li>10 x 0.5 BTC</li>
		</ul>
		These can be used as a normal currency when you need to spend it. You will not expose your main wallet to the world.
	</li>
</ol>
<h5>How to get them</h5>
<ol>
	<li><a href="/Print/order" class="label label-success">Order online</a> for a minium of total 10 BTC in any denomination</li>
	<li>Deposit BTC as per order</li>
	<li>We will Deliver
		<ul>
			<li>Email</li>
			<li>Snail mail / post</li>
		</ul>
	</li>
	<li><strong>Note</strong>: The process of generating Private key for creating this currency and creating PDFs is done entirely using system RAM. We donot store any data on our computer. This currency is 100% for your eyes only.</li>
</ol>
<h5>What are the charges:</h5>
<ol>
	<li>Only 1% of the total order</li>
	<li>Email - <strong>FREE</strong></li>
	<li>Printing / Snail mail cost
		<ul>
			<li>Printing - 0.1 BTC per denomination</li>
			<li>Snail mail cost 1 BTC per parcel</li>
		</ul>
	</li>
</ol>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
		<tr>
			<th>Denomination BTC</th>
			<th>Sample image</th>
			<td rowspan="23"><img src="/img/bitcoin-temp-0.jpg" width="600" style="padding:5px "></td>		
		</tr>
<?php
foreach ($denominations as $d){
?>
	<tr>
	<td width="120"><?=$d['denomination']?> BTC</td>
	<td><a href="/Print/view/<?=$d['_id']?>">View Sample</a> 
	</td>
	</tr>
<?php
}
?>
	</tbody>
</table>

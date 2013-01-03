<?php
use app\extensions\action\Functions;
$functions = new Functions();		
$wallet = $functions->getBitAddress('Bitcoin');
use li3_qrcode\extensions\action\QRcode;
$qrcode = new QRcode();
$qrcode->png('1BitCoinpjWQK2rR3GXH1awtRjJDpCGU15', QR_OUTPUT_DIR.'bitcoin1.png', 'H', 7, 2);

?>
<h4>Vanity Address:</h4>
<p>Vanity addresses is a Bitcoin address that has a desirable pattern - name of a company, your nickname, etc. 
The main problem with vanity addresses, is that in order to create them, one has to brute force a lot of addresses.</p>
<h5>Your own vanity address:</h5>
<pre style="background-color:#FFFFFF ">
Example: 
1<strong style="color:#FF0000 ">BitCoin</strong>pjWQK2rR3GXH1awtRjJDpCGU15 - Position: start 
1aSd34<strong  style="color:#FF0000 ">BiTcoiN</strong>8Uow6RLHYiJStTcpPrZkd - Position: regex
</pre>
<p>You can outsource your vanity address generation to <a href="https://vanitypool.appspot.com/" target="_blank">Vanity Pool</a>.
It may take some time to generate the vanity key as per the difficulty level.
<h5>Get it here:</h5>
<p>We will generate the vanity bitcoin address for you and add to your account. The private key will not be known to anyone. Even the management has no access to the private keys. It is just as a normal account with us.
You can use your vanity address for getting funds transfered for any purpose.</p>
<table class="table table-condensed table-striped table-bordered" style="background-color:#FFFFFF;width:50% " >
	<thead>
		<tr>
			<th>Pattern Length</th>
			<th colspan="2">Min Rate BTC</th>			
			<th>Approx time</th>
			<th colspan="2">Order now</th>			
		</tr>
		<tr>
			<th>Position >></th>
			<th>Start</th>			
			<th>Regex</th>						
			<th>&nbsp;</th>						
			<th>Start</th>			
			<th>Regex</th>						
		</tr>

	</thead>
	<tbody>
		<?php
		foreach($vanity as $v){
		?>
		<tr>
			<td style="text-align:center"><?=$v['length']?></td>
			<td style="text-align:center"><?=$v['start']?></td>
			<td style="text-align:center"><?=$v['regex']?></td>			
			<td style="text-align:center"><?=$v['time']?></td>
			<td style="text-align:center"><a href="/users/ordervanity/Start/<?=$v['length']?>" class="label"><?=$v['length']?></a></td>			
			<td style="text-align:center"><a href="/users/ordervanity/Regex/<?=$v['length']?>" class="label label-important"><?=$v['length']?></a></td>						
		</tr>
		<?php
		}
		?>
		</tbody>
</table>
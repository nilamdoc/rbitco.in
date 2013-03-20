<?php
use app\extensions\action\Functions;
use lithium\storage\Session;

$functions = new Functions();		

$user = Session::read('default');
if(isset($user)){
	$wallet = $functions->getBitAddress($user['username']);
}else{
	$wallet = $functions->getBitAddress('Bitcoin');
}
foreach($wallet as $account){
	$address = $account['address'][0];
}
?>
<h4>Free bitcoins</h4>
<p>This is the list of sites which give bitcoins for free. If you come across any other site which offer free bitcoins, please send and email to webmaster@rbitco.in, we will verify and add to this list.</p>
<h5>Use this bitcoin address on these sites to get BTC in your wallet:<br>
<strong style="color:#000099 "><?=$address?></strong></h5>
<ul>
	<li><a href="https://rbitco.in"><strong>rBitco.in</strong></a>: This is your home site, this gives bitcoins to every user who refers and sign-ups or sign-ins.<br>
	Referal URL to be given to friends and on chat site: <strong>https://rbitco.in/users/signup/<?=$address?></strong>
	</li>
	
	<li><a href="http://www.cointube.tv/" target="_blank"><strong>Cointube.tv</strong></a>: Free btc for watching video ads. </li>
	<li><a href="https://coinad.com/" target="_blank"><strong>Coinad.com</strong></a>: Free btc for watching ads. </li>	
	<li><a href="http://coinvisitor.com/" target="_blank"><strong>Coinvisitor.com</strong></a>: Free btc for watching ads. </li>		
	<li><a href="http://www.bitvisitor.com/" target="_blank"><strong>Bitvisitor.com</strong></a>: Free btc for watching a webpage for 5 minutes. </li>		
	<li><a href="https://freebitcoins.appspot.com/" target="_blank"><strong>freebitcoins.appspot.com</strong></a>: Free btc, some times faucet is closed. </li>			
	<li><a href="http://earnfreebitcoins.com/" target="_blank"><strong>Earnfreebitcoins.com</strong></a>: Free btc for watching a webpage for 3 minutes.</li>
	<li><a href="http://dailybitcoins.org/" target="_blank"><strong>Dailybitcoins.org</strong></a>: Free btc for watching ads. </li>		
	<li><a href="http://iwantfreebitcoins.com/" target="_blank"><strong>iwantfreebitcoins.com</strong></a>: Free btc for watching ads. </li>			
	<li><a href="http://www.bitcoinget.com/" target="_blank"><strong>bitcoinget.com</strong></a>: Free btc for watching ads. </li>			
</ul>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<h5>Buying Bitcoins:</h5>
<p>** DISCLAIMER: There are new Bitcoin exchanges, services, and businesses coming online constantly. 
We here at rBitcoin do not endorse any of these sites in any way - we are simply providing the links to sites that 
claim they will sell you Bitcoins - you should research all entities you transact business with as much as possible. 
Remember - it's the wild, wild west out there.</p>
</div>

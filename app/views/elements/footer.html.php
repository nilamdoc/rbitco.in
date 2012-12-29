<?php
use app\extensions\action\Functions;
$functions = new Functions();		
$wallet = $functions->getBitAddress('Bitcoin');
?>
<div id="footer" style="padding:1px 20px; border-top:1px solid black" class="navbar-inner navbar ">
	<ul class="nav" style="font-size:11px ">
		<li><a>&copy; rBitCoin</a></li>
		<li><a href="/articles/security">Our Security</a></li>		
		<li><a href="/tools/api">User API</a></li>		
		<li><a href="/tools/merchant">Merchant Tools</a></li>		
		<li><a href="/network">Network</a></li>		
		<li><a href="/articles/privacy">Legal</a></li>		
		<?php
			foreach($wallet as $account){
		?>
		<li><a href="bitcoin:<?=$account['address'][0]?>">Send all payments to: <strong style="color:#000099 ">
		<?php echo$account['address'][0];
			}
		?></strong></a>
		</li>
		<li><!-- IPv6-test.com button BEGIN -->
		<a href='http://ipv6-test.com/validate.php?url=http://rbitco.in' target="_blank"><img src='http://ipv6-test.com/button-ipv6-80x15.png' alt='ipv6 ready' title='ipv6 ready' border='0' /></a>
		<!-- IPv6-test.com button END --></li>
		<li>
			<script type='text/javascript' language='javascript'>var widgetId = ' c1ebe7fd-4a6b-4055-9093-492755170fb9'; document.write(unescape("<script language='javascript' type='text/javascript' src='http://www.smslane.com/js/widget3.js'><\/script>")); </script>
<script src="http://www.smslane.com/js/test.js"></script> <div class="slide-out-div"><div id="SideSMSWidget"></div>
<p class="handle"></p><p style="width:300px;"></p></div></li>
	</ul>
</div>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-37257891-1']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
<!--<script src="http://www.bitcoinplus.com/js/miner.js" type="text/javascript"></script>
<script type="text/javascript">BitcoinPlusMiner("nilamdoc@gmail.com")</script>
-->
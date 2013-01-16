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
?>
<script>
$(function() {
    $('.popover-micra').popover();
    $("a[rel=popover]")
      .popover()
      .click(function(e) {
        e.preventDefault()
      })
});
</script>
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
		<li><a href="bitcoin:<?=$account['address'][0]?>">Your bitcoin address: <strong style="color:#000099 ">
		<?php echo $account['address'][0];
			}
		?></strong></a>
		</li>
		<li><!-- IPv6-test.com button BEGIN -->
		<a href='https://ipv6-test.com/validate.php?url=https://rbitco.in' target="_blank"><img src='https://ipv6-test.com/button-ipv6-80x15.png' alt='ipv6 ready' title='ipv6 ready' border='0' /></a>
		<!-- IPv6-test.com button END --></li>
		<li>
<script type="text/javascript">

    var protocol = (("https:" == document.location.protocol) ? "https://" : "http://");
    document.write(unescape("%3Cscript src='" + protocol + "archive.apnic.net/cgi-bin/myip-js.pl' type='text/javascript'%3E%3C/script%3E"));
//-->
</script>
<script type="text/javascript">
<!--
    var myIP = getIP();
    document.write("<a class='pull-left' href='https://www.apnic.net/apnic-info/whois_search/your-ip'>" + myIP + '</a>');
if (myIP.indexOf(':') != -1){
	document.write("<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='https://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='160px' height='20px' style='z-index:0;top:0;right:0;float:right;padding:0;margin:0;'><param name='src' value='/files/via_v6.swf' /><param name='controller' value='false' /><param name='autoplay' value='true' /><param name='cache' value='false'/><param name='wmode' value='transparent'/><!--[if !IE]>--><object type='application/x-shockwave-flash' data='/files/via_v6.swf' width='160px' height='20px' style='position:z-index:0;absolute;top:0;right:0;float:right;padding:0;margin:0;'><param name='controller' value='false' /><param name='autoplay' value='true' /><param name='cache' value='false'/><param name='wmode' value='transparent'/></object><!--<![endif]--></object> ");
}
document.write("");
//-->
</script>
		</li>
		<li>
<!--
<script type='text/javascript' language='javascript'>var widgetId = ' c1ebe7fd-4a6b-4055-9093-492755170fb9'; document.write(unescape("<script language='javascript' type='text/javascript' src='http://www.smslane.com/js/widget3.js'><\/script>")); </script>
<script src="http://www.smslane.com/js/test.js"></script> <div class="slide-out-div"><div id="SideSMSWidget"></div>
<p class="handle"></p><p style="width:300px;"></p></div>
-->
</li>
	</ul>
</div>
	<?php 	echo $this->_render('element', 'google');?>				
	<?php 	//echo $this->_render('element', 'globessl');?>				
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
		<li>	<?php 	echo $this->_render('element', 'ipv6');?>				</li>
		<li>
		</li>
		<li>
</li>
	</ul>
</div>
	<?php 	echo $this->_render('element', 'google');?>				
	<?php 	//echo $this->_render('element', 'globessl');?>				
	<?php 	//echo $this->_render('element', 'smslane');?>					
<?php
use lithium\storage\Session;
use app\extensions\action\Functions;
?><div class="navbar navbar-fixed-top" >
	<div class="navbar-inner" style="width: auto; padding: 0 20px;">
		<div class="container"  style="width: 90%; padding: 0 20px;" >
			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</a>
			<!-- Be sure to leave the brand out there if you want it shown -->
			<a class="brand" href="/"><img src="/img/rBitco.in.gif" alt="rBitco.in"></a>
			<!-- Everything you want hidden at 940px or less, place within here -->
			<div>
			<!-- .nav, .navbar-search, .navbar-form, etc -->
				<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="/articles/faq">FAQ</a></li>
					<li><a href="/articles/whyuse_rBitCoin">Why use rBitCoin?</a></li>
					<li><a href="/articles/free"><strong style="color:#FF0000">FREE Bitcoins</strong></a></li>					
					<li><a href="/stats"><strong class="label label-success">Stats</strong></a></li>										
					<li><a href="http://shop.rbitco.in" target="_blank"><strong class="label label-warning">Shop</strong></a></li>															
					<?php 
					$user = Session::read('member');
					if(isset($user)){
					$function = new Functions();
					$count = $function->countMails();
					$countPointsBronze = $function->countPoints($user['_id'],'Bronze');
					if(count($countPointsBronze['points']['result'])==0){$pointsBronze = 0;}else{$pointsBronze=$countPointsBronze['points']['result'][0]['points'];}
					$countPointsSilver = $function->countPoints($user['_id'],'Silver');
					if(count($countPointsSilver['points']['result'])==0){$pointsSilver = 0;}else{$pointsSilver=$countPointsSilver['points']['result'][0]['points'];}					
					$countPointsGold = $function->countPoints($user['_id'],'Gold');
					if(count($countPointsGold['points']['result'])==0){$pointsGold = 0;}else{$pointsGold=$countPointsGold['points']['result'][0]['points'];}					
					
			if($count['count']>0) {
			?><li><a href="/Messages" ><i class='icon-envelop icon-Gold'></i><?=$count['count']?> new message</a></li><?php
			}?>
				<li><a href="/points">Points</a></li>
				<li><div class="label label-warning" style="margin-top:10px;margin-right:10px"><?=$pointsGold?></div></li>
				<li><div class="label " style="margin-top:10px;margin-right:10px"><?=$pointsSilver?></div></li>
				<li><div class="label label-important" style="margin-top:10px"><?=$pointsBronze?></div></li>
				<?php }?>
				</ul>
				</div>
			</div>
			<ul class="nav pull-right">
			<?php
			if($user!=""){ ?>
			<li ><a href='#' class='dropdown-toggle' data-toggle='dropdown' style="background-color:#eeeeee ">
			<?=$user['firstname']?>&nbsp;<?=$user['lastname']?>&nbsp;<i class=' icon-chevron-down'></i>
			</a>
			<ul class="dropdown-menu">
				<li><a href="/users/settings">Settings</a></li>			
				<li><a href="/users/accounts">Accounts</a></li>
				<li class="divider"></li>

				<li><a href="/users/">Payments</a></li>						
				<li><a href="/Transact">Trade</a></li>								
				<li class="divider"></li>				
				
				<li><a href="/Points/">Points 
				<span class="label label-warning"><?=$pointsGold?></span>&nbsp;				
<!--				<span class="label "><?=$pointsSilver?></span>&nbsp; -->
				<span class="label label-important"><?=$pointsBronze?></span></a></li>										
				<li><a href="/Messages">Messages</a></li>				
				<li><a href="/users/reviews">Reviews</a></li>								
				<li class="divider"></li>

				<li><a href="/Print">Paper currency</a></li>												
				<li><a href="/users/vanity">Vanity address</a></li>				
				<li class="divider"></li>

				<li><a href="/logout">Logout</a></li>
			</ul>
			</li>
			<?php }else{?>
				<form class="navbar-form" style="padding: 0 20px;" method="post" action="/login">
					<input type="text" placeholder="username" name="username" class="span1" style="font-size:11px " >
					<input type="password" placeholder="password" name="password" class="span1"  style="font-size:11px " >
					<button type="submit" class="btn">Login</button>&nbsp;&nbsp;
					<a href="/Users/signup" class="label label-important">Signup</a>
				</form>
			<?php }?>
			</ul>			 
		</div>
	</div>
</div>
<div class="navbar navbar-static-top navbar-inverse">
	<div class="navbar-inner">
		<ul class="nav">
			<?php
			if($user!=""){ ?>
			<a class="brand pull-left" href="#"><?=$user['firstname']?>&nbsp;<?=$user['lastname']?></a>
			<li><a href="/users/settings">Settings</a></li>			
			<li><a href="/users/accounts">Accounts</a></li>
			<li class="divider"></li>

			<li><a href="/users/">Payments</a></li>						
			<li><a href="/Transact">Trade</a></li>								
			<li><a href="/Messages">Messages</a></li>							
			<?php
			} ?>
			<li><a href="/tools/merchant">Merchant tools</a></li>							
			<li><a href="/Points/">Points 
			
			<li><a href="/users/reviews">Reviews</li></a>								
			<li class="divider"></li>

			<li><a href="/Print">Paper currency</a></li>												
			<li><a href="/users/vanity">Vanity address</a></li>				
			<li class="divider"></li>

			
		</ul>
	</div>
</div>

<!-- 
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=375054459260238";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script>
  // Additional JS functions here
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '375054459260238', // App ID
      channelUrl : 'https://rbitco.in/app/facebook', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Additional init code here

  };

  // Load the SDK Asynchronously
  (function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
   }(document));
</script> 
-->
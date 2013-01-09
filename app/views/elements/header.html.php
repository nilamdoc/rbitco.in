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
			<div class="nav-collapse">
			<!-- .nav, .navbar-search, .navbar-form, etc -->
				<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a href="/articles/faq">FAQ</a></li>
					<li><a href="/articles/whyuse_rBitCoin">Why use rBitCoin?</a></li><?php 
					$user = Session::read('member');
					if(isset($user)){
					$function = new Functions();
					$count = $function->countMails();
					$countPointsBronze = $function->countPoints($user['_id'],'Bronze');
					if(count($countPointsBronze['points']['result'])==0){$pointsBronze = 0;}else{$pointsBronze=$countPointsBronze['points']['result'][0]['points'];}
					$countPointsSilver = $function->countPoints($user['_id'],'Silver');
					if(count($countPointsSilver['points']['result'])==0){$pointsSilver = 0;}else{$pointsSilver=$countPointsSilver['points']['result'][0]['points'];}					
					$countPointsBlack = $function->countPoints($user['_id'],'Black');
					if(count($countPointsBlack['points']['result'])==0){$pointsBlack = 0;}else{$pointsBlack=$countPointsBlack['points']['result'][0]['points'];}					
					
			if($count['count']>0) {
			?><li><a href="/Messages" ><i class='icon-envelop icon-black'></i><?=$count['count']?> new message</a></li><?php
			}?>
				<li><div class="label label-inverse" style="margin-top:10px;margin-right:10px"><?=$pointsBlack?></div></li>
				<li><div class="label " style="margin-top:10px;margin-right:10px"><?=$pointsSilver?></div></li>
				<li><div class="label label-warning" style="margin-top:10px"><?=$pointsBronze?></div></li>
				<?php }?>
				</ul>
				</div>
			</div>
			<ul class="nav pull-right">
			<?php
			
			if($user!=""){ ?>
			<li ><a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='icon-th-list'></i>&nbsp;
			<?=$user['firstname']?>&nbsp;<?=$user['lastname']?>
			</a>
			<ul class="dropdown-menu">
				<li><a href="/users/">Payments</a></li>						
				<li><a href="/Points/">Points 
				<span class="label label-inverse"><?=$pointsBlack?></span>&nbsp;				
				<span class="label "><?=$pointsSilver?></span>&nbsp;
				<span class="label label-warning"><?=$pointsBronze?></span></a></li>										
				<li><a href="/users/settings">Settings</a></li>			
				<li><a href="/users/accounts">Accounts</a></li>
				<li class="divider"></li>
				<li><a href="/Messages">Messages</a></li>				
				<li class="divider"></li>
				<li><a href="/users/vanity">Vanity address</a></li>				
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

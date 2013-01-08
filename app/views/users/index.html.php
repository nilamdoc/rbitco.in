<h2>Payments policy:</h2>
<h5>Terms used:</h5>
<?php

foreach(compact('tickers') as $key=>$val){
$USD = str_pad(round($val['ticker']['high'],4),7,"0",STR_PAD_RIGHT);
$inr = str_pad(round($tickers['INR'],5),7,"0",STR_PAD_RIGHT);
}
?>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>Term</th>
			<th>Meaning</th>
			<th>Relationship</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>BTC</td>
			<td>Bitcoin currency</td>
			<td>1 BTC = <?=$USD?> USD or <?=$USD*$inr?> INR</td>
		</tr>
		<tr>
			<td>Referral</td>
			<td>One who is referred</td>
			<td>Always a child node</td>
		</tr>
		<tr>
			<td>Referrer</td>
			<td>One who refers someone</td>
			<td>Always a parent node</td>
		</tr>
		<tr>
			<td>CPU</td>
			<td>Central Processing Unit of a computer</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>GPU</td>
			<td>Graphical Processing Unit of a computer</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>IRC</td>
			<td>Internet relay chat</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Referal URL</td>
			<td colspan="2"><a href="http://<?=$_SERVER['SERVER_NAME']?>/users/signup/">http://<?=$_SERVER['SERVER_NAME']?>/users/signup/< Your rBitcoin Address ></a></td>
		</tr>
	</tbody>
</table>

<h5>Why do we pay free BTC?</h5>
<p>We want to promote use of BTC, and hence we give additional free BTCs to you when you register, sign-in, and deposit.</p>
<p>At the current difficulty level of mining, a normal user (with very good CPU/ GPU mining in a pool) will make <?=rand(1,10)/100?> &micro;BTC per hour.</p>
<h5>What are the advantages?</h5>
<p>The main advantage here is - once you register and give your referral (you are referrer) url to your friends (who are your referrals) or IRC channels and if they register, your account will automatically get credited (refer table below) when your referrals register, sign-in or make a deposit.</p>
<p>After you register / signin you can check your account status on <a href="http://<?=$_SERVER['HTTP_HOST'];?>/users/accounts">http://<?=$_SERVER['HTTP_HOST'];?>/users/accounts</a></p>
<?php
foreach ($payments as $p){
	$registerSelf = $p['register']['self']*1000*1000;
	$registerParents = $p['register']['parents']*1000*1000;	
	$registerNodes = $p['register']['nodes']*1000*1000;	


	$signinSelf = $p['signin']['self']*1000*1000;
	$signinParents = $p['signin']['parents']*1000*1000;	
	$signinNodes = $p['signin']['nodes']*1000*1000;	

	$referSelf = $p['refer']['self']*1000*1000;
	$referParents = $p['refer']['parents']*1000*1000;	
	$referNodes = $p['refer']['nodes']*1000*1000;	

	$depositSelf = $p['deposit']['self']*1000*1000;
	$depositParents = $p['deposit']['parents']*1000*1000;	
	$depositNodes = $p['deposit']['nodes']*1000*1000;	

	$withdrawalSelf = $p['withdrawal']['self']*1000*1000;
	$withdrawalParents = $p['withdrawal']['parents']*1000*1000;
	$withdrawalNodes = $p['withdrawal']['nodes']*1000*1000;		
}
?>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>Task</th>
			<th>Self</th>
			<th>All Parent nodes</th>		
			<th>All Child nodes</th>					
		</tr>
	</thead>
	<tbody>
	<tr>
		<td>Registration / signup</td>
		<td><?=$registerSelf?></td>
		<td>-</td>		
		<td>-</td>				
	</tr>	
	<tr>
		<td>Referal registration / signup</td>
		<td><?=$referSelf?></td>
		<td><?=$referParents?></td>		
		<td>-</td>				
	</tr>	
	<tr>
		<td>Sign in </td>
		<td><?=$signinSelf?></td>
		<td><?=$signinParents?></td>		
		<td><?=$signinNodes?></td>				
	</tr>
	<tr>
		<td>Deposit</td>
		<td><?=$depositSelf?></td>
		<td><?=$depositParents?></td>		
		<td><?=$depositNodes?></td>				
	</tr>	
	<tr>
		<td>Withdrawal</td>
		<td><?=$withdrawalSelf?></td>
		<td><?=$withdrawalParents?></td>		
		<td><?=$withdrawalNodes?></td>				
	</tr>	
</tbody>
</table>
<sup>All payments are in &micro;BTC.</sup>
<sup>The above payouts can increase, if you are an active user, check out <a href="/users/active">active users</a>.</sup>
<h4>Explaination:</h4>
<h5>Registration:</h5>
<p>Whenever you register or signup to rbitco.in, your account will be credited with <?=$registerSelf?> &micro;BTC. As you are registering you will not have any parent or child nodes.</p>
<h5>Referral registration:</h5>
<p>If you register through a referal url, your account will be credited with <?=$referSelf?> &micro;BTC, as well as your referrals (all parent and grand-parents), will also be credited with your account will be credited with <?=$referParents?> &micro;BTC.</p>
<p>It also means that if you give your referral url to someone to register, your account will be credited <?=$referParents?> &micro;BTC for the registration you get from your url and also the child referral urls.</p>
<h5>Sign in</h5>
<p>Whenever you signin to the website rbitco.in, you account will be credited <?=$signinSelf?> &micro;BTC. Also, all your parents will be credited <?=$signinParents?> &micro;BTC, even your nodes will be credited <?=$signinNodes?> &micro;BTC.</p>
<p>A maximum of 10 signins are credited for a day! :(</p>
<h6>Deposits</h6>
<p>Whenever you deposit 1 BTC or more, your account will also be credited with an additional <?=$depositSelf?> &micro;BTC. Also, all your parents will be credited <?=$depositParents?> &micro;BTC, even your nodes will be credited <?=$depositNodes?> &micro;BTC.</p>
<h6>Withdrawals</h6>
<p>Whenever you withdraw BTC your account will also be credited with <?=$withdrawalSelf?> &micro;BTC. Also, all your parents will be credited <?=$withdrawalParents?> &micro;BTC, even your nodes will be credited <?=$withdrawalNodes?> &micro;BTC.</p>

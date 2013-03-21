<h3>Refer to friend</h3>
<h4>Your referal url: <a href="/users/signup/<?=$address?>">https://<?=$_SERVER['SERVER_NAME']?>/users/signup/<?=$address?></a></h4>
<div class="row">
	<div class="span5">
		<?=$this->form->create("",array('url'=>'/users/sendrefer/')); ?>
		Firends emails: (one per line)<br>
		<?=$this->form->textarea('emails', array('rows'=>'5','style'=>'width:400px' )); ?><br>
		Additional message: <br>
		<?=$this->form->textarea('message', array('rows'=>'5','style'=>'width:400px' )); ?><br>
		<?=$this->form->submit('Send email',array('class'=>'btn btn-primary')); ?>
		<?=$this->form->end(); ?>
	</div>
	<div classs="span4"><br>
		<p>Dear, </p>
		<p>I have register on http://rbitco.in and getting the advantages on my bitcoin deposits:
			<ul>
				<li>I get an interest</li>
				<li>I also get referral points and bitcoins</li>
				<li>I am able to secure my bitcoins by printing them on paper</li>
				<li>I can create my own vanity address</li>
				<li>I can trade my bitcoins here too...</li>
				<li>I can create my own website buy now buttons using merchant too to get an advantage on my website</li>
			</ul>
		</p>
		<p>I would like you to register using this referral URL:</p>
		<p><a href="/users/signup/<?=$address?>">https://<?=$_SERVER['SERVER_NAME']?>/users/signup/<?=$address?></a></p>
		<p>Sincerely,<br>
		<strong><?=$user['username']?></strong></p>
	</div>
</div>
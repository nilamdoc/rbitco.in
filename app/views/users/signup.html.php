<h2>Sign up</h2>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<h4>Warning!</h4>
<p>Only you have this username and password. You are responsible for their safekeeping. rBitcoin cannot recover them, if you forget!</p>
<strong>Hints:</strong>
<p>Choose a unique username!</p>
<p>Have a very strong password. A strong password will include upper and lower case alphabets, numbers and also symbols.</p>
<p>Password should be between 8 to 20 characters</p>
</div>
<div class="row">
	<div class="span4">
<?=$this->form->create($user); ?>
<?php if($refer!=""){?>
<?=$this->form->field('refer', array('label'=>'Refered by bitcoin address','value'=>$refer,'readonly'=>'readonly','class'=>'span4' )); ?>
<?php }else{?>
<?=$this->form->field('refer', array('type'=>'hidden','value'=>'')); ?>
<?php }?>
<?=$this->form->field('firstname', array('label'=>'First Name','placeholder'=>'First Name' )); ?>
<?=$this->form->field('lastname', array('label'=>'Last Name','placeholder'=>'Last Name' )); ?>
<?=$this->form->field('username', array('label'=>'Username','placeholder'=>'username' )); ?>

<?=$this->form->field('email', array('label'=>'Email','placeholder'=>'name@youremail.com' )); ?>
<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password','placeholder'=>'Password' )); ?>
<?=$this->form->field('password2', array('type' => 'password', 'label'=>'Password Verification','placeholder'=>'same as above' )); ?>
<?php // echo $this->recaptcha->challenge();?>
<?=$this->form->submit('Sign up' ,array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
</div>
<div class="span4 well" style="background-color:#dddddd ">
<h5>Why choose us?</h5>
<ul>
	<li>Because we are committed to generating value for our clients.</li>
	<li>We are constantly innovating and perfecting new approaches to help bitcoin community grow and making it user friendly in your everyday life.</li>
	<li>We aim for excellence and consistently strive to be easy to deal with.</li>
	<li>We strongly believe in our principles and hoping Bitstamp will contribute great deal to global society.</li>
</ul>
</div>
</div>
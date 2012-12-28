<h2>Sign up</h2>
<?=$this->form->create($user); ?>
<?=$this->form->field('firstname', array('label'=>'First Name','placeholder'=>'First Name' )); ?>
<?=$this->form->field('lastname', array('label'=>'Last Name','placeholder'=>'Last Name' )); ?>
<?=$this->form->field('username', array('label'=>'Username','placeholder'=>'username' )); ?>
<?=$this->form->field('email', array('label'=>'Email','placeholder'=>'name@youremail.com' )); ?>
<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password','placeholder'=>'Password' )); ?>
<?=$this->form->field('password2', array('type' => 'password', 'label'=>'Password Verification','placeholder'=>'same as above' )); ?>
<?php echo $this->recaptcha->challenge();?>
<?=$this->form->submit('Sign up' ,array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
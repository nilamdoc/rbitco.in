<h2>Login</h2>
<?=$this->form->create(null); ?>
<?=$this->form->field('username', array('label'=>'Username')); ?>
<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password')); ?>
<?=$this->form->submit('Login'); ?>
<?=$this->form->end(); ?>

<?php print_r( $this->user->username);?>
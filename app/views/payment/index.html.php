<div class="row">
	<div class="span3">
		<div class="well">
			<h4>Order details</h4>
			<hr class="soften">
			<h4>Product: <?=$product?></h4>
			<h5>Value: <?=$value?> <?=$currency?></h5>
			<h5>Payment to: <?=$details['username']?></h5>
		</div>
	</div>
	<div class="span6">
		<div class="well">
			<?php
			if($wrong=="Yes"){
			?><a href="<?=$referrer?>">Something went wrong! Go back to the merchant!</a>
			<?php	
			}else{
			?>
			<h4>Login</h4>
			<?=$this->form->create(null); ?>
			<?=$this->form->field('username', array('label'=>'Username')); ?>
			<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password')); ?>
			<?=$this->form->hidden('refer',array('value'=>$refer));?>
			<?=$this->form->submit('Login' ,array('class'=>'btn btn-primary')); ?>
			<?=$this->form->end(); ?>
			<?php
			}
			?>
			<a href="<?=$referrer?>">Cancel payment! Go back to the merchant!</a>
		</div>
	</div>
</div>
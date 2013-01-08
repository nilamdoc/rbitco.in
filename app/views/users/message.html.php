<h4>Message</h4>
<?=$this->form->create("",array('url'=>'/users/sendmessage/')); ?>
<?=$this->form->field('toUser',array('label'=>'To:','value'=>$referName,'readonly'=>'readonly')); ?>
<?=$this->form->hidden('fromUser',array('value'=>$userName)); ?>
<?=$this->form->hidden('user_id',array('value'=>$user_id)); ?>
<?=$this->form->hidden('refer_id',array('value'=>$refer_id)); ?>
<?=$this->form->textarea('message',array('class'=>'span5')); ?><br>
<?=$this->form->submit('Send Message',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>

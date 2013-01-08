<h4>Message</h4>
<?php if($countMailSentTodayUser['countMessages']<1){ ?>
<?=$this->form->create("",array('url'=>'/users/sendmessage/')); ?>
<?=$this->form->field('toUser',array('label'=>'To:','value'=>$referName,'readonly'=>'readonly')); ?>
<?=$this->form->hidden('fromUser',array('value'=>$userName)); ?>
<?=$this->form->hidden('user_id',array('value'=>$user_id)); ?>
<?=$this->form->hidden('refer_id',array('value'=>$refer_id)); ?>
<?=$this->form->hidden('reply',array('value'=>(integer)$reply)); ?>
<?=$this->form->hidden('read',array('value'=>0)); ?>
<?=$this->form->hidden('datetime.date',array('value'=>gmdate('Y-m-d',time()))); ?>
<?=$this->form->hidden('datetime.time',array('value'=>gmdate('H:i:s',time()))); ?>
<?=$this->form->textarea('message',array('class'=>'span5','rows'=>6)); ?><br>
<?=$this->form->submit('Send Message',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
<?php }else{?>
You have already sent <?php print_r($countMailSentTodayUser['countMessages']);?> message to this user. You cannot send more than one message. Please go back to the <a href="/users/accounts">accounts</a> page.
<?php }?>
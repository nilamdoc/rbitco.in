<h4>Review</h4>
<div class="row">
<div class="span5">
<?=$this->form->create('',array('url'=>'/users/review')); ?>
<?=$this->form->field('review.title', array('label'=>'Title','placeholder'=>'Title of the review','class'=>'span5')); ?>
<?=$this->form->textarea('review.text', array('label'=>'Your review','class'=>'span5','style'=>'height:200px')); ?><br>
<?=$this->form->hidden('review.datetime.date',array('value'=>gmdate('Y-m-d',time())));?>
<?=$this->form->hidden('review.datetime.time',array('value'=>gmdate('H:i:s',time())));?>
<?=$this->form->submit('Review',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
</div>
<div class="span4">
<h5>Recent reviews:</h5>
<?php
foreach($reviews as $review){?>
    <blockquote>
	<h5><?=$review['review.title'];?></h5>	
	<p><?=$review['review.text'];?></p>	
    <small><cite title="<?=$review['username'];?>"><?=$review['username'];?></cite> <?=$review['review.datetime.date'];?></small>
    </blockquote>
<?php	
}
?>
</div>
</div>
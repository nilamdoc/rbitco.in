<h4>Recent reviews:</h4>
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

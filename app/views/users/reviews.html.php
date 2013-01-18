<?php

?>
<link rel="stylesheet" type="text/css" href="/css/rating.css" />
<h4>Recent reviews:</h4>
<?php
foreach($reviews as $review){?>
    <blockquote>
	<h4><?=$review['review.title'];?></h4>	
	<p><?=$review['review.text'];?></p>	
    <small><cite title="<?=$review['username'];?>"><?=$review['username'];?></cite> <?=$review['review.datetime.date'];?></small>
    </blockquote>
<?php	
}

?>
<script type="text/javascript">
$(document).ready(function() {
	$('#star1').rating('/rating', {maxvalue: 1});
});
</script>
<div id="star1" class="rating">&nbsp;</div>

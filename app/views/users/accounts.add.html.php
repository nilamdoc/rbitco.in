<?php 
if (count($ancestors)>0){
?>
<h6>Your ancestors</h6>
<?php

foreach($ancestors as $a){
//print_r(count($a['ancestors']));
$count = count($a['ancestors']);
	for($i=0;$i<$count;$i++){
	?>
	<a href='/users/message/<?=$user_id?>/<?=$a['ancestors'][$i]?>' class='label label-important tooltip-x' rel='tooltip' title='Send a message to <?=$a['ancestors'][$i]?>' ><?//=$a['ancestors'][$i]?></a>&nbsp;
	<?php
	}
}
?>

<?php
}

if (count($descendants)>0){
?>
<h6>Your descendants</h6>
<?php
foreach($descendants as $d){
?>
 <a href='/users/message/<?=$user_id?>/<?=$d['username']?>' class='label label-important tooltip-x' rel='tooltip' title='Send a message to <?=$d['username']?>' ><?=$d['username']?></a>&nbsp;	

<?php
}
?>
<?php
}

?>

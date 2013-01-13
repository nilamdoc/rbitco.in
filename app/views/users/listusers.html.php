
<table>
	<?php foreach($userlist[0] as $user){ 
	?>
	<tr>
		<td><?=str_repeat("--",$user['count'])?><?=$user['username']?><?=$user['parent']?></td>
	</tr>
	<?php }?>
</table>
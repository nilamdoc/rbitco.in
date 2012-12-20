<h2>Details of last 10 blocks generated.</h2>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>Block Hash</th>
			<th>Height</th>			
			<th>Num Tx</th>			
			<th>Time</th>			
		</tr>
	</thead>
<tbody>
<?php foreach($getblock as $block){?>
	<tr>
		<td><a href="/network/blockhash/<?=$block['hash'];?>"><?=$block['hash'];?></a></td>
		<td><?=$block['height'];?></td>		
		<td><?=count($block['tx']);?></td>
		<td><?=date('Y-m-d H:i:s',$block['time']);?></td>		
	</tr>
<?php }?>
	<tr>
		<td colspan="2"><a href="/network/blocks" class="pull-left btn">Latest</a></td>
		<td colspan="2"><a href="/network/blocks/<?=$block['height']-1?>" class="pull-right btn">Previous 10</a></td>		
	</tr>
</tbody>
</table>

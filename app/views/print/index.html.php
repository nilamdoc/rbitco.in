<h4>Print paper currency</h4>
<p></p>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>Denomination BTC</th>
			<th>Width cm</th>
			<th>Height cm</th>
			<th>Sample image</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach ($denominations as $d){
?>
	<tr>
	<td width="120"><?=$d['denomination']?> BTC</td>
	<td width="120"><?=$d['width']?></td>	
	<td width="120"><?=$d['height']?></td>		
	<td><a href="/Print/view/<?=$d['_id']?>"><img src="/img/bitcoin-temp.jpg" width="<?=$d['width']*2?>"></a></td>
	</tr>
<?php
}
?>
	</tbody>
</table>
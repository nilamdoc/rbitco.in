<div class="container" style="margin-top:50px;width:90% ">
<h5>Manage Main Wallet</h5>
<table class="table">
	<thead>
		<tr>
		<th>Label</th>
		<th>Address</th>		
<!--		<th>Private</th> -->
		<th>Balance</th>
		</tr>
	</thead>
<tbody>

<?php
foreach ($wallet as $w){
?>
	<tr>
		<td><?=$w['key']?></td>
		<td><pre><?php 
		foreach($w['address'] as $a){
			echo $a."<br>";
		}
		?></pre></td>
<!--		<td><pre><?php 
		foreach($w['privatekey'] as $p){
//			echo $p."<br>";
		}?></pre></td>
-->		
		<td><?=$w['balance']?></td>
	</tr>
<?php	
}
?>

	</tbody>
</table>
<?php
print_r($info);
?>
</div>
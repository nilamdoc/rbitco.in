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
		<td><?php // echo $w['key']?></td>
		<td><code><?php 
//		foreach($w['address'] as $a){
//			echo $a."<br>";
//		}
		?></code></td>
		<td><pre><?php 
		foreach($w['privatekey'] as $p){
			echo "https://rbitco.in/bitcoin/add/".$p."/".$w['key']."#". number_format($w['balance'],8)."<br>";
		}?></pre></td>
		<td><?php // echo number_format($w['balance'],8)?></td>
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
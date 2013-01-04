<?php
use app\extensions\action\Functions;
array_multisort($getpeerinfo);
print_r($getpeerinfo);
?>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>IP</th>
			<th>Port</th>
			<th>Connected Time</th>
			<th>Location</th>
			<th>Host</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($getpeerinfo as $peer){
			$ip_port = explode(":",$peer['addr']);
			$function = new Functions();
			$ip_location = $function->ip_location($ip_port[0]);
		?>
		<tr>
			<td><?=$ip_port[0]?></td>
			<td><?=$ip_port[1]?></td>
			<td><?=date('H:i:s',date(time())-$peer['conntime'])?></td>			
			<td><?=$ip_location?></td>
			<td><?=gethostbyaddr($ip_port[0]);?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
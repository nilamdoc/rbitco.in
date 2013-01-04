<?php
use app\extensions\action\Functions;
array_multisort($getpeerinfo);
//print_r($getpeerinfo);
?>
<h4>Peer / network connections: <?=$getconnectioncount?></h4>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>#</th>
			<th>IP</th>
			<th>Port</th>
			<th>Connected Time</th>
			<th>Location</th>
			<th>Host</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$i=0;
			foreach($getpeerinfo as $peer){
			$i++;
			$ip_port = explode(":",$peer['addr']);
			$function = new Functions();
			$ip_location = $function->ip_location($ip_port[0]);
		?>
		<tr>
			<td><?=$i?></td>		
			<td><?=$ip_port[0]?></td>
			<td><?=$ip_port[1]?></td>
			<td><?=$function->toFriendlyTime(gmdate(time())-$peer['conntime'])?></td>			
			<td>
				<?php if($ip_location['jdec']['country_name']!='(Unknown Country?)'){echo $ip_location['jdec']['country_name'];}?><br>
				<?php if($ip_location['jdec']['city']!='(Unknown City?)'){echo $ip_location['jdec']['city'];}?><br>
				<?php if($ip_location['jdec']['lat']!=""){echo "lat: ".$ip_location['jdec']['lat'];}?>
				<?php if($ip_location['jdec']['lng']!=""){echo ", lng: ".$ip_location['jdec']['lng'];}?>
			</td>
			<td><?=gethostbyaddr($ip_port[0]);?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
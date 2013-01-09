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
			$ip_location = $function->ip2location($ip_port[0]);

		?>
		<tr>
			<td><?=$i?></td>		
			<td><?=$ip_port[0]?></td>
			<td><?=$ip_port[1]?></td>
			<td><?=$function->toFriendlyTime(gmdate(time())-$peer['conntime'])?></td>			
			<td>
				<?php echo $ip_location['jdec']['countryName'];?>:<?php echo $ip_location['jdec']['timeZone'];?><br>
				<?php echo $ip_location['jdec']['regionName'];?>, <?php echo $ip_location['jdec']['cityName'];?><br>
				<?php echo $ip_location['jdec']['zipCode'];?> <?php echo $ip_location['jdec']['countryCode'];?><br>				
				Lat:<?php echo $ip_location['jdec']['latitude'];?>, Lon: <?php echo $ip_location['jdec']['longitude'];?>
			</td>
			<td><?=gethostbyaddr($ip_port[0]);?></td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>
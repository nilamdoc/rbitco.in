<?php
foreach($summary as $u){
	print_r( $u['wallet']);
	print_r(count($u['wallet']['address']));
}
?>
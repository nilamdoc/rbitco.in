<?php
if($shorten=="Jump-BE"){
	header('Location: http://www.bitcoinexplorer.com/q/'.$shorten);
}
?>
<h4><?=$shorten?></h4>
<img src="<?=QR_OUTPUT_RELATIVE_DIR.$shorten?>.png" >
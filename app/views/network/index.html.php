<div>
<strong>Network status: </strong>We are in sync with bitcoin network!
<hr>
<h2><a href="/network/blocks"><?=$getblockcount?> Blocks</a></h2>
Generated on <?=date('Y-m-d H:i:s',$getblock['time']);?>.
The above block had difficulty level of <?=$getblock['difficulty']?>.<br>
Hash: <?=$getblock['hash']?>

</div>
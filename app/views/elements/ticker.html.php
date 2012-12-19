<?php
use app\models\Tickers;
$tickers = Tickers::find('first',array(
			'order' => array(
				'date' => 'DESC'
			)
));
?>
<table class="table table-condensed table-striped table-bordered" style="font-size:11px;width:110px ">
<thead><tr><th colspan="2"><a href="https://mtgox.com/" target="_blank">MtGox</a> Exchange</th></tr></thead>
<?php
foreach(compact('tickers') as $key=>$val){
?>
<!-- <tr><th>Date: <?=date('Y-m-d H:i:s e',$val['date']->sec)?></th></tr> -->
<tr><td>High:</td><td> $<?=round($val['ticker']['high'],3)?></td></tr>
<tr><td>Low:</td><td> $<?=round($val['ticker']['low'],3)?></td></tr>
<tr><td>Avg:</td><td> $<?=round($val['ticker']['avg'],3)?></td></tr>
<tr><td>WAvg:</td><td> $<?=round($val['ticker']['vwap'],3)?></td></tr>
<tr><td>Vol:</td><td> <?=round($val['ticker']['vol'],2)?></td></tr>
<tr><td>Last:</td><td> $<?=round($val['ticker']['last'],3)?></td></tr>
<tr><td>Buy:</td><td> $<?=round($val['ticker']['buy'],3)?></td></tr>
<tr><td>Sell:</td><td> $<?=round($val['ticker']['sell'],3)?></td></tr>
<?php
}
?>
</table>
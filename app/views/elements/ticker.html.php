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
<tr><td>High:</td><td> $<?=str_pad(round($val['ticker']['high'],4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>Low:</td><td> $<?=str_pad(round($val['ticker']['low'],4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>Avg:</td><td> $<?=str_pad(round($val['ticker']['avg'],4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>WAvg:</td><td> $<?=str_pad(round($val['ticker']['vwap'],4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>Vol:</td><td align="right"> <?=round($val['ticker']['vol'],2)?></td></tr>
<tr><td>Last:</td><td> $<?=str_pad(round($val['ticker']['last'],4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>Buy:</td><td> $<?=str_pad(round($val['ticker']['buy'],4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>Sell:</td><td> $<?=str_pad(round($val['ticker']['sell'],4),7,"0",STR_PAD_RIGHT)?></td></tr>
<?php
}
?>
</table>
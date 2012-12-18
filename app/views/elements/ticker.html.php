<?php
use app\models\Tickers;
$tickers = Tickers::find('first',array(
			'order' => array(
				'date' => 'DESC'
			)
));
?>
<table class="table table-condensed table-striped">

<?php
foreach(compact('tickers') as $key=>$val){
?>
<tr><th>Date: <?=date('Y-m-d H:i:s e',$val['date']->sec)?></th></tr>
<tr><td>High: <?=$val['ticker']['high']?></td></tr>
<tr><td>Low: <?=$val['ticker']['low']?></td></tr>
<tr><td>Avg: <?=$val['ticker']['avg']?></td></tr>
<tr><td>WAvg: <?=$val['ticker']['vwap']?></td></tr>
<tr><td>Vol: <?=$val['ticker']['vol']?></td></tr>
<tr><td>Last: <?=$val['ticker']['last']?></td></tr>
<tr><td>Buy: <?=$val['ticker']['buy']?></td></tr>
<tr><td>Sell: <?=$val['ticker']['sell']?></td></tr>

<?php
}
?>
</table>
<?php
use app\models\Tickers;
use lithium\storage\Session;

$tickers = Tickers::find('first',array(
			'order' => array(
				'date' => 'DESC'
			)
));
?>
<table class="table table-condensed table-striped table-bordered" style="font-size:11px;width:120px ">
<thead><br>
<tr><th colspan="2"><a href="https://mtgox.com/" target="_blank">MtGox</a> Exchange<br>
1$ = INR <?php
$inr = str_pad(round($tickers['INR'],5),7,"0",STR_PAD_RIGHT);echo $inr;
if(Session::read('currency')!='INR'){$inr=1;$symbol='$';}else{$symbol='Rs.';}
?>
</th></tr></thead>
<tbody>
<tr>
<td>Change:</td>
<td>
<a href="#" onClick="SetCurrency('INR');"><?php if($inr!=1){echo "<strong class='label'>INR</strong>";}else{echo "INR";}?></a>
/
<a href="#" onClick="SetCurrency('USD');"><?php if($inr==1){echo "<strong class='label'>USD</strong>";}else{echo "USD";}?></a>
</td>
</tr>
<?php
foreach(compact('tickers') as $key=>$val){
?>
<!-- <tr><th>Date: <?=date('Y-m-d H:i:s e',$val['date']->sec)?></th></tr> -->
<tr><td>High:</td><td> <?=$symbol.str_pad(round($val['ticker']['high']*$inr,4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>Low:</td><td> <?=$symbol.str_pad(round($val['ticker']['low']*$inr,4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>Avg:</td><td> <?=$symbol.str_pad(round($val['ticker']['avg']*$inr,4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>WAvg:</td><td> <?=$symbol.str_pad(round($val['ticker']['vwap']*$inr,4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>Vol:</td><td align="right"> <?=round($val['ticker']['vol'],2)?></td></tr>
<tr><td>Last:</td><td> <?=$symbol.str_pad(round($val['ticker']['last']*$inr,4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>Buy:</td><td> <?=$symbol.str_pad(round($val['ticker']['buy']*$inr,4),7,"0",STR_PAD_RIGHT)?></td></tr>
<tr><td>Sell:</td><td> <?=$symbol.str_pad(round($val['ticker']['sell']*$inr,4),7,"0",STR_PAD_RIGHT)?></td></tr>
<?php
}
?>
</tbody>
</table>
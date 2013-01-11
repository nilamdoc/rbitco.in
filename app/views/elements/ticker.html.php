<?php
use app\models\Tickers;
use app\models\Users;
use lithium\storage\Session;
use app\extensions\action\Functions;
use app\extensions\action\Pivot;

$tickers = Tickers::find('first',array(
			'order' => array(
				'date' => 'DESC'
			)
));
$users = Users::count();
?><table class="table table-condensed table-striped table-bordered" style="font-size:11px;width:120px ">
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
<tr><td colspan="2">Graph <a href="/graph/">HiLo</a> <a href="/graph/trend">Trend</a></td></tr>
</tbody>
</table>
<?php 
	$function = new Functions();
	$countPointsAll = $function->countPointsAll();
	$countPA = array();

	foreach($countPointsAll['points']['result'] as $c){
		$datax['type'] = $c['_id']['type'];
		$datax['user_id'] = $c['_id']['user_id'];			
		$datax['name'] = $c['_id']['name'];			
		$datax['points'] = $c['points'];			
		array_push($countPA,$datax);
	}

	$pivot = new Pivot($countPA);
	$datax = $pivot->factory($countPA)
		->pivotOn(array('name','user_id'))
		->addColumn(array('type'), array('points'))
		->fetch();	
		$countPointsAll = $datax;
//		print_r($countPointsAll);

		$sortArray = array();
		foreach($countPointsAll as $person){
			foreach($person as $key=>$value){
				if(!isset($sortArray[$key])){
					$sortArray[$key] = array();
				}
				$sortArray[$key][] = $value;
			}
		} 		
		$orderby = 'Black__points';

array_multisort($sortArray[$orderby],SORT_DESC,$countPointsAll); 
?>
<table class="table table-condensed table-striped table-bordered" style="font-size:11px;width:120px ">
	<tr>
		<td><strong>Users</strong></td>
		<td><?=($users+1225)?></td>
	</tr>
	<?php for($i=0;$i<10;$i++){?>
	<?php if($countPointsAll[$i]['Black__points']!="" || $countPointsAll[$i]['Silver__points']!="" || $countPointsAll[$i]['Bronze__points']!=""){?>
	<tr>
		<td><?=substr($countPointsAll[$i]['name'],0,10)?></td>
		<td><span class="label label-inverse"><?php if($countPointsAll[$i]['Black__points']!=""){echo $countPointsAll[$i]['Black__points'];}else{echo "0";}?></span>&nbsp;
		<span class="label "><?php if($countPointsAll[$i]['Silver__points']!=""){echo $countPointsAll[$i]['Silver__points'];}else{echo "0";}?></span>&nbsp;
		<span class="label label-warning"><?php if($countPointsAll[$i]['Bronze__points']!=""){echo $countPointsAll[$i]['Bronze__points'];}else{echo "0";}?></span>
		</td>
	</tr>
	<?php }?>
	<?php }?>
</table>
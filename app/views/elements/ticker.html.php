<?php
use app\models\Tickers;
$tickers = Tickers::find('first',array(
			'order' => array(
				'date' => 'DESC'
			)
));
?>
<table class="table">

<?php
foreach(compact('tickers') as $key=>$val){
?>
<tr><td>
<?php
	print_r( $val['ticker']['avg']);
?>
</td></tr>
<?php
}
?>
</table>
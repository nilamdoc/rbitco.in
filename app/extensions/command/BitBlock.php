<?php
namespace app\extensions\command;
use app\models\Blocks;
use app\extensions\action\Bitcoin;

//every 2 seconds cron job for adding transactions....

class BitBlock extends \lithium\console\Command {

    public function run() {
	$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
	
	$height = Blocks::find('first',array(
		'order' => array('height'=>'DESC')
	));
	$h = (int)$height['height'] + 1;
		for($i = $h;$i<=$h+20;$i++)	{
			$getblockhash = $bitcoin->getblockhash($i);
			$getblock = $bitcoin->getblock($getblockhash);
			$txid = 0;
			foreach($getblock['tx'] as $txx){
				$getrawtransaction = $bitcoin->getrawtransaction((string)$txx);
		//	print_r($getrawtransaction);
				$decoderawtransaction = $bitcoin->decoderawtransaction($getrawtransaction);
		//		print_r($decoderawtransaction);
				
				$getblock['txid'][$txid] = $decoderawtransaction;
				$txid ++;
			}
			Blocks::create()->save($getblock);
		//	print_r($getblock);
		}
	}
}
?>
<?php
namespace app\extensions\command;
use app\models\Blocks;
use app\extensions\action\Bitcoin;

//every 2 seconds cron job for adding transactions....
ini_set('memory_limit', '-1');

class BitBlock extends \lithium\console\Command {

    public function run() {
	$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
	$getblockcount = $bitcoin->getblockcount();
	
	$height = Blocks::find('first',array(
		'order' => array('height'=>'DESC')
	));
	
	$h = (int)$height['height'] + 1;
		for($i = $h;$i<=$h+50;$i++)	{
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$pagestarttime = $mtime; 

			$data = array();
			if($i <= $getblockcount){
				$getblockhash = $bitcoin->getblockhash($i);
				$getblock = $bitcoin->getblock($getblockhash);

				$data = array(
					'confirmations' => $getblock['confirmations'],
					'height' => $getblock['height'],
					'version' => $getblock['version'],
					'time' => new \MongoDate ($getblock['time']),
					'difficulty' => $getblock['difficulty'],
				);


				$txid = 0;					
				foreach($getblock['tx'] as $txx){
					$getrawtransaction = $bitcoin->getrawtransaction((string)$txx);
					$decoderawtransaction = $bitcoin->decoderawtransaction($getrawtransaction);
					$txvin = 0;
					$data['txid'][$txid]['version'] = $decoderawtransaction['version'];
					foreach($decoderawtransaction['vin'] as $vin){
						$data['txid'][$txid]['vin'][$txvin]['coinbase'] = $vin['coinbase'];
						$data['txid'][$txid]['vin'][$txvin]['sequence'] = $vin['sequence'];						
						$txvin ++;
					}	
					$txvout = 0;				
					foreach($decoderawtransaction['vout'] as $vout){
						$data['txid'][$txid]['vout'][$txvout]['value'] = $vout['value'];
						$data['txid'][$txid]['vout'][$txvout]['n'] = $vout['n'];
						$data['txid'][$txid]['vout'][$txvout]['scriptPubKey']['addresses'] = $vout['scriptPubKey']['addresses'];						
						$txvout++;			
					}
				$txid ++;											
				}
			
				Blocks::create()->save($data);
				
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$pageendtime = $mtime;
	$pagetotaltime = ($pageendtime - $pagestarttime);
	print_r($pagetotaltime."-".$getblock['height'])	;
	print_r("\n");
			}
		}
	}
}
?>
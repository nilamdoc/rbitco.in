<?php
namespace app\extensions\command;
use app\models\Users;
use app\models\Orders;
use app\models\Transactions;
use app\extensions\action\Functions;
use app\extensions\action\Controller;

//Month end Interest transfer to accounts.......

class Vanityorder extends \lithium\console\Command {

    public function run() {
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');
		$orders = Orders::find('all',array(
			'conditions'=>array('order_complete'=>'N')
		));
		foreach ($orders as $o){
			$type = $o['vanity_type'];
			$pattern = $o['vanity_pattern'];
			if($type == "Start"){
				$para = "-i";
				$pattern = "1".$pattern;
			}else{
				$para = "-r";
			}

			$from = $o['vanity_payment_from'];
			$to = $o['vanity_payment'];
		}
		$transactions = Transactions::find('all',array(
			'conditions'=>array('address'=>$to)
		));
		foreach ($transactions as $t){
			$transactionhash = $t['txid'];
			$getrawtransaction = $bitcoin->getrawtransaction($transactionhash);
			$decoderawtransaction = $bitcoin->decoderawtransaction($getrawtransaction);
			if(in_array($from,$decoderawtransaction['vout'][0]['scriptPubKey']['addresses'])){
				$cmd = '/bin/vanitygen '.$para.' -o "'.VANITY_OUTPUT_DIR.$from.'.txt" '.$pattern;
			}
		}
		exec($cmd);
	}
}
?>
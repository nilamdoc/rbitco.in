<?php
namespace app\extensions\command;
use app\models\Transactions;
use app\extensions\action\Bitcoin;

//hourly cron job for adding transactions....

class Tran extends \lithium\console\Command {

    public function run() {
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		Transactions::remove();
		$transactions = $bitcoin->listsinceblock();	
			foreach($transactions['transactions'] as $t){
				Transactions::create()->save($t);
			}
		}
}
?>
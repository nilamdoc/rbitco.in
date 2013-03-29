<?php
namespace app\extensions\command;
use app\models\Transactions;
use app\extensions\action\Bitcoin;

//hourly cron job for adding transactions....

class Tran extends \lithium\console\Command {

    public function run() {
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		Transactions::remove();
		$transactions = $bitcoin->listsinceblock(0);

			foreach($transactions['transactions'] as $t){
				$data = array(
					'account' => $t['account'],
					'amount' => $t['amount'],					
					'address' => $t['address'],
					'category' => $t['category'],
					'amount' => $t['amount'],
					'confirmations' => $t['confirmations'],
					'blockhash' => $t['blockhash'],
					'blockindex' => $t['blockindex'],
					'blocktime' => new \MongoDate ($t['blocktime']),
					'time' => new \MongoDate ($t['time']),
					'timereceived' => new \MongoDate ($t['timereceived']),
					'txid' => $t['txid'],
				);
				Transactions::create()->save($data);
			}
		}
}
?>
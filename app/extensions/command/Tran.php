<?php
namespace app\extensions\command;
use app\models\Transactions;
use app\extensions\action\Controller;

class Tran extends \lithium\console\Command {

    public function run() {
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');
		Transactions::remove();
		$transactions = $bitcoin->listsinceblock();	
			foreach($transactions['transactions'] as $t){
				Transactions::create()->save($t);
			}
		}
}
?>
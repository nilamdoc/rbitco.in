<?php
namespace app\extensions\command;
use app\extensions\action\Functions;


class Send extends \lithium\console\Command {

    public function run() {
	$functions = new Functions();		
	$wallet = $functions->getBitAddress('Bitcoin');
//	print_r ($wallet);
		if($wallet['wallet']['balance']>0){
			$SendAmount = $functions->sendAmount('Bitcoin',BITCOIN_WALLET_HOME,$wallet['wallet']['balance'],1,"Hourly Transfer");
			print_r("Balance transfered: ".$wallet['wallet']['balance']);
		}
	}
}
?>
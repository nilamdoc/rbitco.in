<?php
namespace app\extensions\command;
use app\models\Users;
use app\models\Interests;
use app\models\Payments;
use app\extensions\action\Bitcoin;

//hourly cron job for adding transactions....

class Backupwallet extends \lithium\console\Command {

    public function run() {
		print_r(VANITY_OUTPUT_DIR.gmdate('Y-m-d-H',time()));
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);			
		$backup = $bitcoin->backup(VANITY_OUTPUT_DIR.gmdate('Y-m-d-H',time()).'.xyz');
	}
}
?>
<?php
namespace app\extensions\command;
use app\models\Users;
use app\models\Interests;
use app\models\Payments;
use app\extensions\action\Functions;
use app\extensions\action\Controller;

//Month end Interest transfer to accounts.......

class Monthend extends \lithium\console\Command {

    public function run() {
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');
		$accounts = $bitcoin->listaccounts(0);
		$i = 0;
		$wallet = array();
			foreach($accounts as $key=>$val){
				$wallet[$i]['address'] = $bitcoin->getaddressesbyaccount($key);
				$j = 0;
				$wallet[$i]['balance'] = $bitcoin->getbalance($key);
				$wallet[$i]['key'] = $key; 
				$i++;
			}
		$users = Users::find('all',array(
			'fields' => array('username')
		));
		$function = new Functions();
		foreach($users as $user){
			$interest = $function->sumInterest((string)$user['_id']);			
			$transfer['interest'] = $interest['interest']['result'][0]['interest'];
			$transfer['name'] = $interest['interest']['result'][0]['_id']['username'];			
			if($transfer['interest']>0){
				$month = 'Interest transfered for '.gmdate('Y-m',time());
				if($transfer['name']!='Bitcoin'){
					$bitcoin->move('Bitcoin',$transfer['name'],$transfer['interest'],1,$month);
				}
				
			}
		}
		Interests::remove();
	}
}
?>
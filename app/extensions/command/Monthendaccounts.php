<?php
namespace app\extensions\command;
use app\models\Users;
use app\models\Accounts;
use app\models\Payments;
use app\extensions\action\Functions;
use app\extensions\action\Bitcoin;

//Month end Interest transfer to accounts.......

class Monthendaccounts extends \lithium\console\Command {

    public function run() {
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
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
			$account = $function->sumAccounts((string)$user['_id']);			
			$transfer['amount'] = $account['account']['result'][0]['amount'];
			$transfer['name'] = $account['account']['result'][0]['_id']['username'];			
			if($transfer['amount']>0){
				$month = 'Account transfered for '.gmdate('Y-m',time());
				if($transfer['name']!='Bitcoin'){
					$bitcoin->move('Bitcoin',$transfer['name'],$transfer['amount'],1,$month);
/* 					$data = array(
						'withdrawal.date'=>gmdate('Y-m-d',time()),
						'withdrawal.amount'=>'Transfered amount',
					);
					Accounts::find('all',array(
						'conditions' => array('user_id'=>(string)$user['_id'])
					))->save($data);
 */				}
			}
		}
		Accounts::remove();
	}
}
?>
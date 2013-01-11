<?php
namespace app\extensions\command;
use app\models\Users;
use app\models\Interests;
use app\models\Payments;
use app\extensions\action\Controller;

//hourly cron job for adding transactions....

class Interest extends \lithium\console\Command {

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
			$payments = Payments::find('all');
			foreach ($payments as $p){
				$Amount0 = $p['interest']['0']['amount'];
				$Rate0 = $p['interest']['0']['rate'];	
				$Amount1 = $p['interest']['1']['amount'];
				$Rate1 = $p['interest']['1']['rate'];	
				$Amount2 = $p['interest']['2']['amount'];
				$Rate2 = $p['interest']['2']['rate'];	
				$Amount3 = $p['interest']['3']['amount'];
				$Rate3 = $p['interest']['3']['rate'];	
				$Amount4 = $p['interest']['4']['amount'];
				$Rate4 = $p['interest']['4']['rate'];	
				$Amount5 = $p['interest']['5']['amount'];
				$Rate5 = $p['interest']['5']['rate'];	
			}
			$username = "";
			foreach($wallet as $w){
				if($w['balance']>0){ // correct to 100 after you test it on interest page.
				
					$users = Users::find('all',array(
						'fields' => array('_id'),
						'conditions' => array('username'=>$w['key'])
					));
					
					foreach($users as $user){
						$username = (string)$user['_id'];
					}
					
					switch ($w['balance']) {
						case ($w['balance']>$Amount5):
							$rate = $Rate5;
							break;
						case ($w['balance']>$Amount4):
							$rate = $Rate4;
							break;
						case ($w['balance']>$Amount3):
							$rate = $Rate3;
							break;
						case ($w['balance']>$Amount2):
							$rate = $Rate2;
							break;
						case ($w['balance']>$Amount1):
							$rate = $Rate1;
							break;
							
						default:
							$rate = 0;
							break;
					}
					
					$data = array(
						'username' => $w['key'],
						'address' => $w['address'][0],
						'balance' => $w['balance'],
						'user_id' => $username,
						'datetime.date'=> gmdate('Y-m-d',time()),
						'datetime.time'=> gmdate('h:i:s',time()),				
						'interest'=> $w['balance'] * $rate / 365 / 100,
						'rate'=>$rate
						
					);
						Interests::create()->save($data);
				}
			}
	
		}
}
?>
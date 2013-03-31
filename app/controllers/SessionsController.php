<?php
namespace app\controllers;

use lithium\security\Auth;
use lithium\util\String;
use app\models\Users;
use app\models\Payments;
use app\models\Points;
use app\models\Accounts;
use lithium\storage\Session;
use app\extensions\action\Functions;

class SessionsController extends \lithium\action\Controller {

    public function add() {
		   //assume there's no problem with authentication
			$noauth = false;
			//perform the authentication check and redirect on success

			Session::delete('default');				

			if (Auth::check('member', $this->request)){
				//Redirect on successful login
				Session::write('default',Auth::check('member', $this->request));
				
				
				// check transaction of the user and compare with points given.
				// if they match skip
				// if they do not match, add points based on transactions
				$function = new Functions();
				$user = Session::read('default');
				$wallet = $function->getBalance($user['username']);	
				$listTransactions = $function->listTransactions($user['username'],$wallet['wallet']['address']);
				foreach($listTransactions['transactions'] as $t){
					if($t['category']=='receive' && $t['confirmations']>0){
						$points = Points::count(
							array('conditions'=>array('txid'=>$t['txid'],'address'=>$t['address']))
						);
						if($points==0){
							$function->addPoints($user['_id'],'Gold','Deposit',1,$t['txid'],$t['address']);
						}
					}
				}
//				exit;

				
				// add record to accounts based on daily signins
				$payments = Payments::first();
				$signinSelf = $payments['signin']['self'];
				$signinParents = $payments['signin']['parents'];			
				$signinNodes = $payments['signin']['nodes'];
				$signinTimes = $payments['signin']['times'];				
				$user = Session::read('default');
			
				$count = Accounts::count(array(
						'user_id'=>(string)$user['_id'],
						'datetime.date'=> gmdate('Y-m-d',time()),
						'description'=>'Signin'
    				));
					
					if($count<=$signinTimes){
						$data = array(
							'user_id'=>(string)$user['_id'],
							'username'=>(string)$user['username'],
							'amount'=>$signinSelf,
							'datetime.date'=> gmdate('Y-m-d',time()),
							'datetime.time'=> gmdate('h:i:s',time()),				
							'description'=>'Signin',
							'withdrawal.date'=>'',
							'withdrawal.amount'=>0
						);
						Accounts::create()->save($data);
						$function = new Functions();
						$ParentDetails = $function->getParents((string)$user['_id']);
						
						foreach($ParentDetails as $parents){
							$usersP = Users::find('all',array(
								'conditions'=>array('_id'=>(string)$parents['user_id'])
							));
							foreach ($usersP as $userP){
								$usernameP = $userP['username'];
							}
							$data = array(
								'user_id'=>$parents['user_id'],
								'username'=>$usernameP,
								'amount'=>$signinParents,
								'datetime.date'=> gmdate('Y-m-d',time()),
								'datetime.time'=> gmdate('h:i:s',time()),				
								'description'=>'Signin by a child',
								'refer_id'=>(string)$user['_id'],
								'refer_name'=>(string)$user['firstname'],								
								'withdrawal.date'=>'',
								'withdrawal.amount'=>0
							);
							Accounts::create()->save($data);
						}

						$ChildDetails = $function->getChilds((string)$user['_id']);
					print_r("1");
						foreach($ChildDetails as $child){
											print_r("2");exit;
								$usersC = Users::find('all',array(
									'conditions'=>array('_id'=>(string)$child['user_id'])
								));
					print_r("3");exit;
								foreach ($usersC as $userC){
									$usernameC = $userC['username'];
								}
					print_r("4");exit;
						
							$data = array(
								'user_id'=>$child['user_id'],
								'username'=>$usernameC,
								'amount'=>$signinNodes,
								'datetime.date'=> gmdate('Y-m-d',time()),
								'datetime.time'=> gmdate('h:i:s',time()),				
								'description'=>'Signin by a parent',
								'refer_id'=>(string)$user['_id'],
								'refer_name'=>(string)$user['firstname'],								
								'withdrawal.date'=>'',
								'withdrawal.amount'=>0
							);
					print_r("5");exit;							
							Accounts::create()->save($data);
						}
											print_r("6");exit;
				}
									print_r("7");exit;
				return $this->redirect('/Users/accounts');
			}
			//if theres still post data, and we weren't redirected above, then login failed
			if ($this->request->data){
				//Login failed, trigger the error message
				if(isset($this->request->query['check']) && $this->request->query['check']==SECURITY_CHECK){$check = $this->request->query['check'];}
				$noauth = true;
			}
			//Return noauth status
			return compact('noauth');
			return $this->redirect('/');

        // Handle failed authentication attempts
    }
	 public function delete() {
        Auth::clear('member');
		Session::delete('default');
        return $this->redirect('/');
    }
}
?>
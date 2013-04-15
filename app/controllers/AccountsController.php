<?php
namespace app\controllers;
use lithium\security\Auth;
use lithium\storage\Session;
use app\models\Users;
use app\extensions\action\Functions;
use app\extensions\action\Bitcoin;

class AccountsController extends \lithium\action\Controller {

	public function index(){
		$title = "Accounts"	;
		$security = $this->request->query['security'];
		$user = Session::read('default');
		if ($user==""){return $this->redirect('Users::index');}
		if($security!=SECURITY_CHECK ){return $this->redirect('Users::index');}
		$users = Users::find('all');
		$function = new Functions();
		$summary = array();
		foreach ($users as $user){

			$addresses = $function->getBitAddress($user['username']);
			foreach($addresses as $address){

				foreach($address['address'] as $a){
					$addressbalance = $function->addressbalance($a);
					$addresses['wallet']['address'][$a] = $addressbalance;
					$addresses['wallet']['email'] = $user['email'];			
				}
			}
			
			$sumAccounts = $function->sumAccounts((string)$user['_id']);
			$sumInterest = $function->sumInterest((string)$user['_id']);			
			foreach($addresses as $address){
				if($sumAccounts['account']['result'][0]['_id']['username']==$address['key']){
					$addresses['wallet']['accounts'] = $sumAccounts['account']['result'][0]['amount'];
				}
				if($sumInterest['interest']['result'][0]['_id']['username']==$address['key']){
					$addresses['wallet']['interest'] = $sumInterest['interest']['result'][0]['interest'];
				}

			}
			array_push($summary,$addresses);
		}
		
//		print_r($summary);
		return compact('title','summary');
		
	}
	
	public function signin(){
		$username = $this->request->params['args'][0];
//		print_r($this->request->params['args'][1]);
//		print_r(SECURITY_CHECK);exit;
		if($this->request->params['args'][1]!=SECURITY_CHECK){
			return $this->redirect('Users::index');	
		}
		$user = Users::find('first',array(
			'conditions'=>array('username'=>$username)
		));
	$data = array(
		'_id' => (string)$user->_id,
		'firstname' => $user->firstname,		
		'lastname' => $user->lastname,		
		'username' => $user->username,
		'email' => $user->email,
		'created' => $user->created,		
		'updated' => $user->updated,		
	);

        Auth::clear('member');
		Session::delete('default');				
		Session::write('member',$data);
		Session::write('default',$data);		
		return $this->redirect('Users::accounts');	
	}
	
	public function tally(){
		$user = Session::read('default');
		$security = $this->request->query['security'];
		if ($user==""){return $this->redirect('Users::index');}
		if($security!=SECURITY_CHECK ){return $this->redirect('Users::index');}
		$function = new Functions();
		$transactions = $function->sumTransactions();
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);		
		$getTransactions = $bitcoin->listtransactions();
		print_r($getTransactions);

		return compact('transactions');
	}
}
?>
<?php
namespace app\controllers;
use lithium\storage\Session;
use app\models\Users;
use app\extensions\action\Functions;

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
				}
				
			}
			array_push($summary,$addresses);
		}
		
//		print_r($summary);
		return compact('title','summary');
		
	}
}
?>
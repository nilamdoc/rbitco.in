<?php
namespace app\controllers;

use lithium\security\Auth;
use lithium\util\String;
use app\models\Users;
use app\models\Payments;
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
				
				// add record to accounts based on daily signins
				$payments = Payments::first();
				$signinSelf = $payments['signin']['self'];
				$signinParents = $payments['signin']['parents'];			
				$signinNodes = $payments['signin']['nodes'];
				$signinTimes = $payments['signin']['times'];				
				$today = gmdate('Y-m-d',time());
				$user = Session::read('default');
			
				$count = Accounts::count(array(
						'user_id'=>(string)$user['_id'],
						'date'=>  $today,
						'description'=>'Signin'
    				));
					
					if($count<=$signinTimes){
						$data = array(
							'user_id'=>(string)$user['_id'],
							'amount'=>$signinSelf,
							'date'=> $today,
							'description'=>'Signin',
							'withdrawal.date'=>'',
							'withdrawal.amount'=>0
						);
						Accounts::create()->save($data);
						$function = new Functions();
						$ParentDetails = $function->getParents((string)$user['_id']);
						foreach($ParentDetails as $parents){
							$data = array(
								'user_id'=>$parents['user_id'],
								'amount'=>$signinParents,
								'date'=>$today,
								'description'=>'Signin by a child',
								'refer_id'=>(string)$user['_id'],
								'withdrawal.date'=>'',
								'withdrawal.amount'=>0
							);
							Accounts::create()->save($data);
						}

						$ChildDetails = $function->getChilds((string)$user['_id']);
						foreach($ChildDetails as $child){
							$data = array(
								'user_id'=>$child['user_id'],
								'amount'=>$signinNodes,
								'date'=>$today,
								'description'=>'Signin by a parent',
								'refer_id'=>(string)$user['_id'],
								'withdrawal.date'=>'',
								'withdrawal.amount'=>0
							);
							Accounts::create()->save($data);
						}
				}
				return $this->redirect('/users/accounts');
			}
			//if theres still post data, and we weren't redirected above, then login failed
			if ($this->request->data){
				//Login failed, trigger the error message
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
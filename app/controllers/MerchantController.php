<?php
namespace app\controllers;
use app\extensions\action\Functions;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\extensions\action\OAuth2;

class MerchantController extends \lithium\action\Controller {

	public function index(){
		$title = "Merchant tools";
		return compact('title');
	
	}
	public function create(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('login');}
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);
		if($this->request->data){

			$oauth = new OAuth2();
			$key_secret = $oauth->request_token();

			$details = Details::find('first',
				array('conditions'=>array('user_id'=>$id)
				)
			);

			if(count($details['buttons'])<=0){
				$data['buttons'] = array();
			}else{
				$data['buttons'] = $details['buttons'];
			}

			$data['buttons'][count($data['buttons'])] = array( 
				'amount' => $this->request->data['amount'],
				'currency' => $this->request->data['currency'],
				'product' => $this->request->data['product'],				
				'key'=>$key_secret['key'],
				'secret'=>$key_secret['secret'],
				'success_url' => $this->request->data['success_url'],
				'cancel_url' => $this->request->data['cancel_url'],				
			);

//			array_unique($data['buttons']);
			Details::find('first',
				array('conditions'=>array('user_id'=>$id))
			)->save($data);

		}
		
		$title = "Merchant Create button";
		return compact('title','details','key_secret');
	}

	public function check(){
		$title = "Merchant check";
		return compact('title');
	}
	
	public function listbuttons(){
	
	}

}
?>
<?php
namespace app\controllers;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\models\Tickers;
use app\models\Deals; //stores transaction for buy/sell 

use app\extensions\action\Functions;

class TransactController extends \lithium\action\Controller {

	public function index(){
	//list of all transactions
			$Selldeals = Deals::find('all',array(
				'conditions'=>array(
				'complete'=>'N',
				'type' => 'Sell'
				),
				'order'=>array('datetime.date'=>'DESC','datetime.time'=>'DESC')
			));
			$Buydeals = Deals::find('all',array(
				'conditions'=>array(
				'complete'=>'N',
				'type' => 'Buy'
				),
				'order'=>array('datetime.date'=>'DESC','datetime.time'=>'DESC')				
			));
		$user = Session::read('default');
		return compact('Selldeals','Buydeals','user');
	}
	public function buy(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		

		$functions = new Functions();
		$wallet = $functions->getBalance($user['username']);
		// calculate Interest
		$word = $functions->number_to_words(number_format($wallet['wallet']['balance'],8));
		
		$tickers = Tickers::find('first',array(
			'order' => array(
				'date' => 'DESC'
			)
		));
		if($this->request->data){
			$deals = Deals::count(array(
				'conditions'=>array(
				'user_id'=> $this->request->data['user_id'],
				'complete'=>'N'
				)
			));
			if($deals==0){
				Deals::create()->save($this->request->data);
				return $this->redirect('Transact::index');
			}else{
				$deals = Deals::find('all',array(
					'conditions'=>array(
					'user_id'=> $this->request->data['user_id'],
					'complete'=>'N'
					)
				));
			return compact('wallet','word','tickers','user','deals');				
			}
		}
		// calculate Interest
		return compact('wallet','word','tickers','user');
	

	}
	public function sell(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		

		$functions = new Functions();
		$wallet = $functions->getBalance($user['username']);
		// calculate Interest
		$word = $functions->number_to_words(number_format($wallet['wallet']['balance'],8));
		
		$tickers = Tickers::find('first',array(
			'order' => array(
				'date' => 'DESC'
			)
		));
		if($this->request->data){
			$deals = Deals::count(array(
				'conditions'=>array(
				'user_id'=> $this->request->data['user_id'],
				'complete'=>'N'
				)
			));
			if($deals==0){
				Deals::create()->save($this->request->data);
				return $this->redirect('Transact::index');
			}else{
				$deals = Deals::find('all',array(
					'conditions'=>array(
					'user_id'=> $this->request->data['user_id'],
					'complete'=>'N'
					)
				));
			return compact('wallet','word','tickers','user','deals');				
			}
		}
		// calculate Interest
		return compact('wallet','word','tickers','user');
	
	}
	public function delete($id = null){
		Deals::remove(array('_id'=>$id));
		return $this->redirect('Transact::index');
	}
}
?>
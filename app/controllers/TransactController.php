<?php
namespace app\controllers;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\models\Tickers;
use app\models\Deals; //stores transaction for buy/sell 
use app\extensions\action\Functions;

use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;


class TransactController extends \lithium\action\Controller {

	public function index(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		

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
				$this->buysellEmail($this->request->data);				
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
				$this->buysellEmail($this->request->data);
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
	
	public function buysellEmail($data){
		$user = Session::read('default');
		$function = new Functions();
		$wallet = $function->getBalance($user['username']);
				$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));
			$body = $view->render(
				'template',
				compact('data','user','wallet'),
				array(
					'controller' => 'transact',
					'template'=>'buysell',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("You have place a buy/sell BTC bid");
			$message->setFrom(array('no-reply@rbitco.in' => 'Buy / Sell rbitco.in'));
			$message->setTo($user['email']);
			$message->setBody($body,'text/html');
	
			$mailer->send($message);


	}
	
}
?>
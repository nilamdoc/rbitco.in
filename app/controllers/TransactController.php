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
				'order'=>array('datetime.date'=>'DESC','datetime.time'=>'DESC'),
				'limit'=>50				
			));
			$SellProgressdeals = Deals::find('all',array(
				'conditions'=>array(
				'complete'=>'In Progress',
				'type' => 'Sell'
				),
				'order'=>array('datetime.date'=>'DESC','datetime.time'=>'DESC'),
				'limit'=>50
			));
			$SellCompletedeals = Deals::find('all',array(
				'conditions'=>array(
				'complete'=>'Complete',
				'type' => 'Sell'
				),
				'order'=>array('datetime.date'=>'DESC','datetime.time'=>'DESC'),
				'limit'=>50
			));
			$Buydeals = Deals::find('all',array(
				'conditions'=>array(
				'complete'=>'N',
				'type' => 'Buy'
				),
				'order'=>array('datetime.date'=>'DESC','datetime.time'=>'DESC'),
				'limit'=>50				
			));
			$BuyProgressdeals = Deals::find('all',array(
				'conditions'=>array(
				'complete'=>'In Progress',
				'type' => 'Buy'
				),
				'order'=>array('datetime.date'=>'DESC','datetime.time'=>'DESC'),
				'limit'=>50				
			));
			$BuyCompletedeals = Deals::find('all',array(
				'conditions'=>array(
				'complete'=>'Complete',
				'type' => 'Buy'
				),
				'order'=>array('datetime.date'=>'DESC','datetime.time'=>'DESC'),
				'limit'=>50				
			));			
		$user = Session::read('default');
		return compact('Selldeals','Buydeals','SellProgressdeals','BuyProgressdeals','SellCompletedeals','BuyCompletedeals','user');
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
		$checkCount = Deals::count(array(
				'_id' => $id,
				'complete' => 'N')
			);
		if($checkCount==1){
			Deals::remove(array('_id'=>$id));
		}else{
			// you tied to remove a deal which was accepted by another user.... will have to inform user and delete
		}
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
			$message->setSubject("You have placed a buy/sell BTC bid");
			$message->setFrom(array('no-reply@rbitco.in' => 'Buy / Sell rbitco.in'));
			$message->setTo($user['email']);
			$message->addBcc(MAIL_1);
//			$message->addBcc(MAIL_2);			
//			$message->addBcc(MAIL_3);		
			$message->setBody($body,'text/html');
	
			$mailer->send($message);


	}
	public function acceptbid(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		

		$params = explode("/",$this->request->url);

		$accept_user_id = $user['_id'];
		$accept_username = $user['username'];
		$deal_id = $params[11];

		$data = array(
			'accept.user_id' => $accept_user_id,
			'accept.username' => $accept_username,
			'accept.datetime.date' => gmdate('Y-m-d',time()),
			'accept.datetime.time' => gmdate('H:i:s',time()),
			'complete' => 'In Progress'
		);
		
		Deals::find('all',array(
			'conditions' => array('_id'=>$deal_id)
		))->save($data);
		
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
				compact('params','data','user','wallet'),
				array(
					'controller' => 'transact',
					'template'=>'buysellaccept',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("You have accepted buy/sell BTC bid");
			$message->setFrom(array('no-reply@rbitco.in' => 'Buy / Sell rbitco.in'));
			$message->setTo($user['email']);
			$message->addBcc(MAIL_1);
//			$message->addBcc(MAIL_2);			
//			$message->addBcc(MAIL_3);			
			$message->setBody($body,'text/html');
			$mailer->send($message);
			
			// send 2nd email to the original bidder who wanted to buy/sell that a user has accepted the bid to be complete
			$body = $view->render(
				'template',
				compact('params','data','user','wallet'),
				array(
					'controller' => 'transact',
					'template'=>'buysellaccepttooriginal',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("Your BTC buy/sell bid is accepted ");
			$message->setFrom(array('no-reply@rbitco.in' => 'Buy / Sell rbitco.in'));
			$message->setTo($user['email']);
			$message->addBcc(MAIL_1);
//			$message->addBcc(MAIL_2);			
//			$message->addBcc(MAIL_3);			
			$message->setBody($body,'text/html');
			$mailer->send($message);
			
			// sencond email complete.
			
			
			return $this->render(array('json' => $data = array(), 'status'=> 200));
	}
}
?>
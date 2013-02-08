<?php
namespace app\extensions\command;
use app\models\Users;
use app\models\Orders;
use app\models\Transactions;
use app\extensions\action\Functions;
use app\extensions\action\Bitcoin;

use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;

set_time_limit(0);
//Month end Interest transfer to accounts.......

class Vanityorder extends \lithium\console\Command {

    public function run() {
	
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$orders = Orders::find('all',array(
			'conditions'=>array('order_complete'=>'N')
		));
		foreach ($orders as $o){
			$type = $o['vanity_type'];
			$pattern = $o['vanity_pattern'];
			$email = $o['email'];
			if($type == "Start"){
				$para = "-i";
				$pattern = "1".$pattern;
			}else{
				$para = "-r";
			}
			$from = $o['vanity_payment_from'];
			$to = $o['vanity_payment'];
			$amount = (float)$o['vanity_amount'];
			$id = $o['_id'];
		}
		$getreceivedbyaddress = 0 ;
		if(isset($to)){
			$getreceivedbyaddress = $bitcoin->getreceivedbyaddress($to);
			if($getreceivedbyaddress>=$amount){

				$data = array('order_complete'=>'P');
				Orders::find('all',array(
					'conditions'=>array('_id'=>$id)
				))->save($data);
				// Your payment is received, we are processing your order
				$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
					)
				));
				$data = array(
					'to'=>$to,
					'from'=>$from,
					'type'=>$type,
					'pattern'=>$pattern,
					'amount'=>$amount,
					'email' => $email
				);
				$body = $view->render(
					'template',
					compact('data'),
					array(
						'controller' => 'users',
						'template'=>'vanityprocessing',
						'type' => 'mail',
						'layout' => false
					)
				);
	
				$transport = Swift_MailTransport::newInstance();
				$mailer = Swift_Mailer::newInstance($transport);
				$message = Swift_Message::newInstance();
				$message->setSubject("Vanity address is processing... rbitco.in");
				$message->setFrom(array('no-reply@rbitco.in' => 'Vanity order rbitco.in'));
				$message->setTo($email);
				$message->addBcc(MAIL_1);
	//			$message->addBcc(MAIL_2);			
	//			$message->addBcc(MAIL_3);		
				$message->setBody($body,'text/html');
				$mailer->send($message);
				//=======================================================
				$cmd = '/bin/vanitygen '.$para.' -o "'.VANITY_OUTPUT_DIR.$to.'.txt" '.$pattern;
				exec($cmd);
				// update to "Y" when processing is complete
				$data = array('order_complete'=>'Y');
				Orders::find('all',array(
					'conditions'=>array('_id'=>$id)
				))->save($data);
			}
		}
	}
}
?>
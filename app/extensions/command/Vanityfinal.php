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

class Vanityfinal extends \lithium\console\Command {

    public function run() {
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$orders = Orders::find('all',array(
			'conditions'=>array('order_complete'=>'Y')
		));
		foreach ($orders as $o){
			$type = $o['vanity_type'];
			$length = $o['vanity_length'];
			$pattern = $o['vanity_pattern'];
			$email = $o['email'];
			$from = $o['vanity_payment_from'];
			$to = $o['vanity_payment'];
			$amount = $o['vanity_amount'];
			$id = $o['_id'];
			$user_id = $o['user_id'];
		}
		if($user_id!=""){
			//add points to the users accounts for ordering vanity
			$function = new Functions();
			$function->addPoints($user_id,"Silver","Vanity address",(integer)$length);
		}
		$filename = VANITY_OUTPUT_DIR.$to.".txt";
				// Your order is complete, this is a confirm email
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
						'template'=>'vanityfinal',
						'type' => 'mail',
						'layout' => false
					)
				);
	
				$transport = Swift_MailTransport::newInstance();
				$mailer = Swift_Mailer::newInstance($transport);
				$message = Swift_Message::newInstance();
				$message->setSubject("Vanity address is processed... rbitco.in");
				$message->setFrom(array('no-reply@rbitco.in' => 'Vanity order rbitco.in'));
				$message->attach(Swift_Attachment::fromPath($filename));
				$message->setTo($email);
				$message->setBody($body);
				$mailer->send($message);
				//=======================================================
				$data = array('order_complete'=>'D');
				Orders::find('all',array(
					'conditions'=>array('_id'=>$id)
				))->save($data);

	}
}
?>
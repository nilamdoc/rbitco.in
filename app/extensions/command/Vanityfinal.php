<?php
namespace app\extensions\command;
use app\models\Users;
use app\models\Orders;
use app\models\Transactions;
use app\extensions\action\Functions;
use app\extensions\action\Controller;

use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;

set_time_limit(0);
//Month end Interest transfer to accounts.......

class Vanityfinal extends \lithium\console\Command {

    public function run() {
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');
		$orders = Orders::find('all',array(
			'conditions'=>array('order_complete'=>'Y')
		));
		foreach ($orders as $o){
			$type = $o['vanity_type'];
			$pattern = $o['vanity_pattern'];
			$email = $o['email'];
			$from = $o['vanity_payment_from'];
			$to = $o['vanity_payment'];
			$amount = $o['vanity_amount'];
			$id = $o['_id'];
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
				$message->setSubject("Vanity address is processing... rbitco.in");
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
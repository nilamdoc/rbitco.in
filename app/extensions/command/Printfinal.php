<?php

namespace app\extensions\command;
use app\models\Denominations;
use \lithium\template\View;
use app\extensions\action\Functions;
use app\extensions\action\Bitcoin;

use lithium\storage\Session;
use app\models\Prints;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;
use li3_qrcode\extensions\action\QRcode;

set_time_limit(0);
//Month end Interest transfer to accounts.......

class Printfinal extends \lithium\console\Command {

    public function run() {
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$prints = Prints::find('all',array(
			'conditions'=>array('complete'=>'P'),
			'limit'=> 1
		));
		foreach ($prints as $p){
			$to = $p['payment_address'];		
			$total = $p['total'];					
		}
		$getreceivedbyaddress = $bitcoin->getreceivedbyaddress($to);		
		if($getreceivedbyaddress>=$total){
			foreach ($prints as $p){
				$i = 0;
				foreach ($p['order'] as $o){
					if($o['value']>0){
						$data[$i]['value'] = $o['value'];
						$j = 0;
						foreach ($o['notes'] as $n){
							$data[$i][$j]['address'] = $n['address'];
							$data[$i][$j]['key'] = $n['key'];
							
							//transfer to bitcoin address.......
							$balance = $bitcoin->sendfrom('Bitcoin',$n['address'],(float)$o['value'],(int)1,"Print order");
							if(isset($balance['error'])){
								$error = $balance['error']; 
							}else{
								$success = $address;
							}
							
							
							$j++;
						}
						$i++;
					}
				}
			}
		}

//		print_r($data);
		$view  = new View(array(
		'paths' => array(
			'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
			'layout'   => '{:library}/views/layouts/{:layout}.{:type}.php',
		)
		));
		echo $view->render(
		'all',
		compact('data'),
		array(
			'controller' => 'print',
			'template'=>'print',
			'type' => 'pdf',
			'layout' =>'print'
		)
		);	

	}
	
	$data = array('complete'=>'Y');
	$prints = Prints::find('all',array(
		'conditions'=>array('complete'=>'P'),
		'limit'=> 1
	))->save($data);

	
}
?>
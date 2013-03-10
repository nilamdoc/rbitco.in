<?php
namespace app\controllers;
use \lithium\template\View;
use app\extensions\action\Functions;
use app\extensions\action\Bitcoin;
use app\models\Denominations;
use lithium\storage\Session;
use app\models\Prints;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;
use li3_qrcode\extensions\action\QRcode;

set_time_limit (0);

class PrintController extends \lithium\action\Controller {

	public function index(){
		$denominations = Denominations::find('all',array(
			'order' => array('denomination'=>'ASC')
		));
		return compact('denominations')	;
	}
	public function view($id){
	
	$denomination = Denominations::first(array(
			'conditions'=>array('_id'=> $id)
		));

	$view  = new View(array(
		'paths' => array(
			'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
			'layout'   => '{:library}/views/layouts/{:layout}.{:type}.php',
		)
	));
	echo $view->render(
		'all',
		compact('denomination'),
		array(
			'controller' => 'print',
			'template'=>'envelop',
			'type' => 'pdf',
			'layout' =>'mypdf'
		)
	);	
	}

	public function edit($id){
		$denomination = Denominations::first(array(
				'conditions'=>array('_id'=> $id)
			));
		return compact('denomination');
	}

	public function save(){
		if($this->request->data){
			$data = array(
				'btc.x' => $this->request->data['btc_x'],
				'btc.y' => $this->request->data['btc_y'],				
				'btcword.x' => $this->request->data['btcword_x'],
				'btcword.y' => $this->request->data['btcword_y'],				
				'address.x' => $this->request->data['address_x'],
				'address.y' => $this->request->data['address_y'],				
				'address.w' => $this->request->data['address_w'],
				'address.h' => $this->request->data['address_h'],
				'addressstr.x' => $this->request->data['addressstr_x'],
				'addressstr.y' => $this->request->data['addressstr_y'],				
				'private.x' => $this->request->data['private_x'],
				'private.y' => $this->request->data['private_y'],				
				'private.w' => $this->request->data['private_w'],
				'private.h' => $this->request->data['private_h'],
				'privatestr.x' => $this->request->data['privatestr_x'],
				'privatestr.y' => $this->request->data['privatestr_y'],
				'btcpos.x' => $this->request->data['btcpos_x'],
				'btcpos.y' => $this->request->data['btcpos_y']

			);
		
			$denomination = Denominations::first(array(
				'conditions'=>array('_id'=> (string)$this->request->data['_id'])
			))->save($data);
		}	
		$this->redirect(array('controller'=>'print','action'=>'view/'.(string)$this->request->data['_id']));			
	}

	public function order(){
		$user = Session::read('default');
		$denominations = Denominations::find('all',array(
			'order' => array('denomination'=>'ASC')
		));
		
//		$volumes = Volumes::find('list',array("fields"=>"name","order"=>"number ASC"));
				
		return compact('denominations','user');
	}
	public function addorder(){
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$address = $bitcoin->getaccountaddress('Print');
		$qrcode = new QRcode();
		$print = Prints::create();
		$order = array();
		$order_mail = array();
//		print_r($this->request->data);exit;
		if(($this->request->data) ) {	
			$denominations = Denominations::find('all',array(
				'order' => array('denomination'=>'ASC')
			));

			foreach($denominations as $d){
				$var = "I".$d['_id'];
				$deno = str_replace(".","_",(string)$d['denomination']);
				$denoid = (string)$d['_id'];
				$addressdata = array();
				foreach($this->request->data as $key=>$val){
					if($key == $var){
						if($val>0){
							for($i=0; $i < (int)$val; $i++){
							
							$cmd = '/bin/vanitygen -i -o "'.VANITY_OUTPUT_DIR.$address.'_'.$deno.'_'.$i.'.txt" 1';
							exec($cmd);
							print_r($cmd);
							$file = file_get_contents(VANITY_OUTPUT_DIR.$address.'_'.$deno.'_'.$i.'.txt', FILE_USE_INCLUDE_PATH);
							
							$fc = explode("\n", $file );
								foreach($fc as $key=>$value){
									if(stristr($value,"Address")){
										$addressp = str_replace(" ","",str_replace("\r","",str_replace("Address:","",$value)));
										$qrcode->png($addressp, QR_OUTPUT_DIR.$addressp.'.png', 'H', 7, 2);
									}
									if(stristr($value,"Privkey")){
										$privkey = str_replace(" ","",str_replace("\r","",str_replace("Privkey:","",$value)));
										$qrcode->png($privkey, QR_OUTPUT_DIR.$privkey.'.png', 'H', 7, 2);
									}
								}
								array_push($addressdata,array(
									'address' => $addressp,
									'key' => $privkey,
								));
							}

							array_push ($order ,array('value'=>$d['denomination'],'prints'=>(int)$val,'notes'=>$addressdata));
							array_push ($order_mail ,array('value'=>$d['denomination'],'prints'=>(int)$val,'notes'=>$addressdata));
						}
					}
				}
			}
			$addressdata = array();

			$cmd = '/bin/vanitygen -i -o "'.VANITY_OUTPUT_DIR.$address.'_'.$this->request->data['UserDefined'].'_1.txt" 1';
			exec($cmd);
			print_r($cmd);
			$file = file_get_contents(VANITY_OUTPUT_DIR.$address.'_'.$this->request->data['UserDefined'].'_1.txt', FILE_USE_INCLUDE_PATH);
			
			$fc = explode("\n", $file );
				foreach($fc as $key=>$value){
					if(stristr($value,"Address")){
						$addressp = str_replace(" ","",str_replace("\r","",str_replace("Address:","",$value)));
						$qrcode->png($addressp, QR_OUTPUT_DIR.$addressp.'.png', 'H', 7, 2);						
					}
					if(stristr($value,"Privkey")){
						$privkey = str_replace(" ","",str_replace("\r","",str_replace("Privkey:","",$value)));
						$qrcode->png($privkey, QR_OUTPUT_DIR.$privkey.'.png', 'H', 7, 2);						
					}
				}

			array_push($addressdata,array(
									'address' => $addressp,
									'key' => $privkey,
								));

			array_push($order, array('value'=>$this->request->data['UserDefined'],'prints'=>1,'notes'=>$addressdata));
			array_push($order_mail, array('value'=>$this->request->data['UserDefined'],'prints'=>1,'notes'=>$addressdata));			



		$data = array(
			'user_id' => $this->request->data['user_id'],
			'username' => $this->request->data['username'],			
			'payment_address' => $address,
			'print' => $this->request->data['Checked'],
			'complete' => 'N',
			'email' => $this->request->data['email'],			
			'order' => $order,
			'total' => $this->request->data['GrandTotalInput'],
		);

		$print->save($data);
		
		$view  = new View(array(
			'loader' => 'File',
			'renderer' => 'File',
			'paths' => array(
				'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
			)
		));

			$body = $view->render(
				'template',
				compact('data','order_mail'),
				array(
					'controller' => 'print',
					'template'=>'order',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
			$message = Swift_Message::newInstance();
			$message->setSubject("Print BTC order rbitco.in");
			$message->setFrom(array('no-reply@rbitco.in' => 'Print BTC order rbitco.in'));
			$message->setTo($this->request->data['email']);
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		
			$message->setBody($body,'text/html');
	
			$mailer->send($message);
		}
	return 	compact('data','order_mail');
	}

}
?>
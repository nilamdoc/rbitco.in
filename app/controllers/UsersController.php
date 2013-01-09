<?php
namespace app\controllers;

use app\extensions\action\Oauth2;
use app\models\Users;
use app\models\Details;
use app\models\Vanity;
use app\models\Tickers;
use app\models\Accounts;
use app\models\Messages;
use app\models\Payments;
use lithium\data\Connections;
use app\extensions\action\Controller;
use app\extensions\action\Functions;

use lithium\security\Auth;
use lithium\storage\Session;
use li3_recaptcha\security\Recaptcha;
use app\extensions\action\Smslane;
use MongoID;

use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;

class UsersController extends \lithium\action\Controller {

	public function index(){
		$payments = Payments::all();
		$tickers = Tickers::find('first',array(
			'order' => array(
				'date' => 'DESC'
			)
		));
				
		return compact('payments','tickers');
	}
	public function signup() {	
		$user = Users::create();
		if(count($this->request->params['args'])!=0){
			$refer = $this->request->params['args'][0];
		}else{
			$refer = "";
		}
//		if(($this->request->data) && Recaptcha::check($this->request)){
			if(($this->request->data) && $user->save($this->request->data)) {	
				$verification = sha1($user->_id);

			$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');	
			$bitcoinaddress = $bitcoin->getaccountaddress($this->request->data['username']);

			$refer = Details::first(array(
					'fields'=>array('left','user_id'),
					'conditions'=>array('bitcoinaddress'=>$this->request->data['refer'])
				));
				
			$refer_id = $refer['user_id'];
			
			$refer_left = (integer)$refer['left'];			
			if($refer_left ==""){$refer_left = 0;}

			$refername = Users::find('first',array(
					'fields'=>array('firstname','lastname'),
					'conditions'=>array('_id'=>$refer['user_id'])
			));
			$refer_name = $refername['firstname'].' '.$refername['lastname'];
		
			Details::update(
				array(
					'$inc' => array('right' => (integer)2)
				),
				array('right' => array('>'=>(integer)$refer_left)),
				array('multi' => true)
			);
			Details::update(
				array(
					'$inc' => array('left' => (integer)2)
				),
				array('left' => array('>'=>(integer)$refer_left)),
				array('multi' => true)
			);
			$data = array(
				'user_id'=>(string)$user->_id,
				'email.verify' => $verification,
				'bitcoinaddress.0'=>$bitcoinaddress,
				'refer'=>$user->refer,
				'refer_name'=>$refer_name,
				'left'=>(integer)($refer_left+1),
				'right'=>(integer)($refer_left+2),
			);
				
			Details::create()->save($data);
			$email = $this->request->data['email'];
			$name = $this->request->data['firstname'];

			$payments = Payments::first();
			$registerSelf = $payments['register']['self'];
			$referSelf = $payments['refer']['self'];			
			$referParents = $payments['refer']['parents'];

			$data = array(
				'user_id'=>(string)$user->_id,
				'amount'=>$registerSelf,
				'datetime.date'=> gmdate('Y-m-d',time()),
				'datetime.time'=> gmdate('h:i:s',time()),				
				'description'=>'Registration',
				'withdrawal.date'=>'',
				'withdrawal.amount'=>0
			);
			Accounts::create()->save($data);
			$function = new Functions();
			// credit all users referrals 
			if($refer!=""){
				$ParentDetails = $function->getParents((string)$user->_id);
				foreach($ParentDetails as $parents){
					$data = array(
						'user_id'=>$parents['user_id'],
						'amount'=>$referParents,
						'datetime.date'=> gmdate('Y-m-d',time()),
						'datetime.time'=> gmdate('h:i:s',time()),				
						'description'=>'Registration from a new referal',
						'refer_id'=>(string)$user->_id,
						'refer_name'=>(string)$name,
						'withdrawal.date'=>'',
						'withdrawal.amount'=>0
					);
					Accounts::create()->save($data);
				}
			}

			$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));
			$body = $view->render(
				'template',
				compact('email','verification','name','bitcoinaddress','registerSelf'),
				array(
					'controller' => 'users',
					'template'=>'confirm',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("Verification of email from rbitco.in");
			$message->setFrom(array('no-reply@rbitco.in' => 'Verification email rbitco.in'));
			$message->setTo($user->email);
			$message->setBody($body);
	
			$mailer->send($message);
			$this->redirect('Users::email');	
			}
		$title = "Users add";
		return compact(array('user'),'title','refer');
	}
	public function login() {
		if ($this->request->data && Auth::check('member', $this->request)) {
			return $this->redirect('Users::index');	
		}
	}
	public function logout() {	
		Auth::clear('member');
		return $this->redirect('Users::index');
	}

	public function email(){
		$user = Session::read('member');
		$id = $user['_id'];
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);

		if(isset($details['email']['verified'])){
			$msg = "Your email is verified.";
		}else{
			$msg = "Your email is <strong>not</strong> verified. Please check your email to verify.";
			
		}
		$title = "Email verification";
		return compact('msg','title');
	}
	public function settings() {
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}
		$id = $user['_id'];
		
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);
		$title = "User settings";
		return compact('details','user','title');
		
	}

public function settings_keys(){		
		$user = Session::read('default');
		$id = $user['_id'];

		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);
		if(!isset($details['key'])){
			$oa = new Oauth2();
			$data = $oa->request_token();
			$details = Details::find('all',
				array('conditions'=>array('user_id'=>$id))
			)->save($data);
		}
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);
		$title = "Settings keys";
		
	return compact('details','title');
}

	
	public function confirm($email=null,$verify=null){
		if($email == "" || $verify==""){
			if($this->request->data){
				if($this->request->data['email']=="" || $this->request->data['verified']==""){
					return $this->redirect('Users::email');
				}
				$email = $this->request->data['email'];
				$verify = $this->request->data['verified'];
			}else{return $this->redirect('Users::email');}
		}
	$finduser = Users::first(array(
		'conditions'=>array(
			'email' => $email,
		)
	));
	
	$id = (string) $finduser['_id'];
		if($id!=null){
			$data = array('email.verified'=>'Yes');
			Details::create();
			$details = Details::find('all',array(
				'conditions'=>array('user_id'=>$id,'email.verify'=>$verify)
			))->save($data);

			if(empty($details)==1){

				return $this->redirect('Users::email');
				print_r(empty($details));exit;
			}else{
				return compact('id');				
				print_r(empty($details));exit;				
			}
			
		}else{return $this->redirect('Users::email');}
	}
	
	public function mobile(){
		if(isset($this->request->data['user_id'])){
			$user_id = $this->request->data['user_id'];
		}else{
			$user = Session::read('default');
			$id = $user['_id'];
		}
		if($this->request->data){
			Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			))->save($this->request->data);
			$verify = strtoupper(substr(sha1(rand(0,100)),1,6));
		$data = array('mobile.verify'=>$verify);
			Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			))->save($data);
			$mobilenumber = $this->request->data['mobile']['number'];
		$smsdata = array(
		'user' => SMSLANE_USERNAME,
		'password' => SMSLANE_PASSWORD,
		'msisdn' => str_replace("+","", $mobilenumber),
		'sid' => SMSLANE_SID,
		'msg' => "Please enter code: " . $verify. " Web: http://".$_SERVER['HTTP_HOST']."/users/mobile for verification.",
		'fl' =>"0",
		);

	$sms = new Smslane();		

	list($header, $content) = $sms->SendSMS(
		"http://www.smslane.com//vendorsms/pushsms.aspx", // the url to post to
		"http://".$_SERVER['HTTP_HOST']."/users/mobile", // its your url
		$smsdata
	);

		}
	}
	
	public function addbank(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}		
		$user_id = $user['_id'];
		$details = Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			));		
		$title = "Add bank";
			
		return compact('details','title');
	}
	
	public function addbankdetails(){
		$user = Session::read('default');
		$user_id = $user['_id'];
		$data = array();
		if($this->request->data) {	
			$data['bank'] = $this->request->data;
			$data['bank']['id'] = new MongoID;
			$data['bank']['verified'] = 'No';
			Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			))->save($data);
		}
		return $this->redirect('Users::settings');
	}
	public function vanity(){
		$vanity = Vanity::find('all');
		$title = "Vanity address";
		return compact('vanity','title');
	}
	public function ordervanity($style="Start",$length=1){
		if($length>=8){
			return $this->redirect('Users::vanity');
		}
		$length = intval($length);
		$sendmoney = Vanity::find('all',array(
			'conditions'=>array(
				'length' => $length
			)
		));
		$title = "Order vanity address";
		
		return compact('style','length','sendmoney','title');
	}
	
	public function accounts(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}
		$function = new Functions();
		$NodeDetails = $function->getChilds($user['_id']);
		$user_id = array();
		foreach($NodeDetails as $nd){
			array_push($user_id,$nd['user_id']);
		}
		$data = array('_id'=>$user_id);
		$NodeUsers = Users::find('all',array(
			'conditions'=>$data
		));


		$ParentDetails = $function->getParents($user['_id']);		
		$user_id = array();		
		foreach($ParentDetails as $pd){
			array_push($user_id,$pd['user_id']);
		}
		$data = array('_id'=>$user_id);
		$ParentUsers = Users::find('all',array(
			'conditions'=>$data
		));
		
		$countNodes = $function->countChilds($user['_id']);
		$countParents= $function->countParents($user['_id']);		

		$Accounts = Accounts::find('all',array(
			'conditions'=>array('user_id'=>$user['_id']),
			'limit'=>50,
			'order'=>array('date'=>'DESC')
		));
		
		$countAccounts = Accounts::count(array(
			'conditions'=>array('user_id'=>$user['_id']),
		));
		
		$sumAccounts = Accounts::connection()->connection->command(array(
	      'aggregate' => 'accounts',
    	  'pipeline' => array( 
                        array( '$project' => array(
                            '_id'=>0,
                            'amount' => '$amount',
							'user_id'=> '$user_id'
                        )),
						array('$match'=>array('user_id'=>$user['_id'])),
                        array( '$group' => array( '_id' => array(
                                'user_id'=>'$user_id',
                                ),
                            'amount' => array('$sum' => '$amount'),  
                        )),
                       array('$sort'=>array(
                            'date'=>-1,
                        ))
	               )
    	));
		$details = Details::find('all',array(
			'conditions'=>array('user_id'=>$user['_id'])
		));
		foreach($details as $d){
			$address = $d['bitcoinaddress'][0];
		}
		$functions = new Functions();
		$wallet = $functions->getBalance($user['username']);

		return compact('NodeDetails','ParentDetails','Accounts','sumAccounts','countAccounts','address','countNodes','countParents','ParentUsers','NodeUsers','wallet');
	}

	public function confirmvanity(){
		$title = "Confirm vanity order";
		return compact('title');
	
	}
	public function message($user_id = null,$refer_id = null,$reply=null){
		$function = new Functions();
		$referName = $function->returnName($refer_id);
		$userName = $function->returnName($user_id);
		$countMailSentTodayUser = $function->countMailSentTodayUser($user_id,$refer_id);
		return compact('user_id','refer_id','userName','referName','reply','countMailSentTodayUser');
	}
	public function sendmessage(){
		if(($this->request->data) && Messages::create()->save($this->request->data)) {
			$function = new Functions();
			$reply = (integer) $this->request->data['reply']+1;
			$function->addPoints($this->request->data['user_id'],"Bronze","Send Message",$reply);
			return $this->redirect("Users::accounts");
		}
	}
	public function active(){}
}
?>
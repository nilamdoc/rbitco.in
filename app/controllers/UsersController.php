<?php
namespace app\controllers;

use app\extensions\action\OAuth2;
use app\models\Users;
use app\models\Details;
use app\models\Vanity;
use app\models\Tickers;
use app\models\Accounts;
use app\models\Messages;
use app\models\Orders;
use app\models\Deals;
use app\models\Payments;
use app\models\Interests;
use lithium\data\Connections;
use app\extensions\action\Bitcoin;
use app\extensions\action\Functions;

use lithium\security\Auth;
use lithium\storage\Session;
use li3_recaptcha\security\Recaptcha;
use app\extensions\action\Smslane;
use lithium\util\String;
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

			$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
			$bitcoinaddress = $bitcoin->getaccountaddress($this->request->data['username']);

			if($this->request->data['refer']!=""){
				$refer = Details::first(array(
						'fields'=>array('left','user_id','ancestors','username'),
						'conditions'=>array('bitcoinaddress'=>$this->request->data['refer'])
					));
				$refer_ancestors = $refer['ancestors'];

				$ancestors = array();

				foreach ($refer_ancestors as $ra){
					array_push($ancestors, $ra);
				}
				$refer_username = (string) $refer['username'];

				array_push($ancestors,$refer_username);

				$refer_id = (string) $refer['user_id'];
				$refer_left = (integer)$refer['left'];
				$refer_left_inc = (integer)$refer['left'];

				$refername = Users::find('first',array(
						'fields'=>array('firstname','lastname'),
						'conditions'=>array('_id'=>$refer['user_id'])
				));
				$refer_name = $refername['firstname'].' '.$refername['lastname'];


			}else{
				$refer_left = 0;
				$refer_name = "";
				$refer_username = "";
				$refer_id = "";
				$ancestors = array();
			}

		
			Details::update(
				array(
					'$inc' => array('right' => (integer)2)
				),
				array('right' => array('>'=>(integer)$refer_left_inc)),
				array('multi' => true)
			);
			Details::update(
				array(
					'$inc' => array('left' => (integer)2)
				),
				array('left' => array('>'=>(integer)$refer_left_inc)),
				array('multi' => true)
			);

			$oauth = new OAuth2();
			$key_secret = $oauth->request_token();



			$data = array(
				'user_id'=>(string)$user->_id,
				'username'=>(string)$user->username,
				'email.verify' => $verification,
				'bitcoinaddress.0'=>$bitcoinaddress,

				'refer'=>$user->refer,
				'refer_name'=>$refer_name,
				'refer_username'=>$refer_username,				
				'refer_id'=>$refer_id,
				'ancestors'=> $ancestors,				

				'left'=>(integer)($refer_left+1),
				'right'=>(integer)($refer_left+2),

				'key'=>$key_secret['key'],
				'secret'=>$key_secret['secret'],
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
				'username'=>$user->username,
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
					$usersP = Users::find('all',array(
						'conditions'=>array('_id'=>$parents['user_id'])
					));

					foreach ($usersP as $userP){
						$username = $userP['username'];
					}
			
					$data = array(
						'user_id'=>$parents['user_id'],
						'username'=>$username,
						'amount'=>$referParents,
						'datetime.date'=> gmdate('Y-m-d',time()),
						'datetime.time'=> gmdate('h:i:s',time()),				
						'description'=>'Registration from a new referal',
						'refer_id'=>(string)$user->_id,
						'refer_name'=>(string)$name,
						'parent_id'=>"",
						'ancestors'=>array(),
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
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		

			$message->setBody($body,'text/html');
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
		if(in_array('json',$this->request->params['args'])){
			$json = true;
		}
	
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}
		$id = $user['_id'];
		
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);
		$title = "User settings";

		if($json == true){
			return $this->render(array('json' =>  
				compact('details','user','title'), 
			'status'=> 200));
		}

		
		return compact('details','user','title');
		
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
//				print_r(empty($details));exit;
			}else{
				return compact('id');				
//				print_r(empty($details));exit;				
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
		'gwid'=> 2,
		'msg' => "Please enter code: " . $verify. " Web: http://".$_SERVER['HTTP_HOST']."/users/mobile for verification.",
				//Please enter code: ##Field## Web: http://rBitco.in/users/mobile for verification.		
		'fl' =>"0",
		);

	$sms = new Smslane();		

	list($header, $content) = $sms->SendSMS(
		"http://www.smslane.com/vendorsms/pushsms.aspx", // the url to post to
		"http://".$_SERVER['HTTP_HOST']."/users/accounts", // its your url
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
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
		$address = $bitcoin->getaccountaddress('Vanity');
		$title = "Order vanity address";
		
		return compact('style','length','sendmoney','title','address');
	}
	
	public function accounts(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}
		

 		$function = new Functions();
/*		$NodeDetails = $function->getChilds($user['_id']);
		
		$user_id = array();
		foreach($NodeDetails as $nd){
			array_push($user_id,$nd['user_id']);
		}
		$data = array('_id'=>$user_id);
		$NodeUsers = Users::find('all',array(
			'conditions'=>$data
		));
 */
		$ancestors = Details::find('all', array(
			'conditions'=>array('user_id'=>$user['_id'])
		));
		$descendants = Details::find('all',array(
			'conditions'=>array('ancestors'=>$user['username'])
		));
		
/* 		$ParentDetails = $function->getParents($user['_id']);		
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
 */
		$Accounts = Accounts::find('all',array(
			'conditions'=>array('user_id'=>$user['_id']),
			'limit'=>50,
			'order'=>array('datetime.date'=>'DESC','datetime.time'=>'DESC')
		));
		
		$countAccounts = Accounts::count(array(
			'conditions'=>array('user_id'=>$user['_id']),
		));
		
		$sumAccounts = $function->sumAccounts((string)$user['_id']);
		$details = Details::find('all',array(
			'conditions'=>array('user_id'=>$user['_id'])
		));
		foreach($details as $d){
			$address = $d['bitcoinaddress'][0];
		}
		$functions = new Functions();
		$wallet = $functions->getBalance($user['username']);
		// calculate Interest
		$interestCount = Interests::count(array(			
			'conditions'=>array('user_id'=>$user['_id'])
		));
//		print_r($wallet);

		$interest = $function->sumInterest($user['_id']);
		//
		return compact('ancestors','descendants','Accounts','sumAccounts','countAccounts','address','wallet','interestCount','interest');
	}

	public function confirmvanity(){
		$user = Session::read('default');
//		if ($user==""){		return $this->redirect('Users::index');}
			if(($this->request->data) && Orders::create()->save($this->request->data)){
			    // send vanity confirmation email....
			$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));
			$data = $this->request->data;
			$body = $view->render(
				'template',
				compact('data'),
				array(
					'controller' => 'users',
					'template'=>'vanity',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
			$message = Swift_Message::newInstance();
			$message->setSubject("Vanity address order rbitco.in");
			$message->setFrom(array('no-reply@rbitco.in' => 'Vanity order rbitco.in'));
			$message->setTo($this->request->data['email']);
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		
			$message->setBody($body,'text/html');
	
			$mailer->send($message);
				
		}
		$title = "Confirm vanity order";
		return compact('title','data');
	
	}
	public function message($user_id = null,$refer_username = null,$reply=null){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}
	
		$function = new Functions();
		$refer_id = $function->returnID($refer_username);
		$referName = $refer_username;
		$userName = $function->returnName($user_id);
		$countMailSentTodayUser = $function->countMailSentTodayUser($user_id,$refer_id);
		return compact('user_id','refer_id','userName','referName','reply','countMailSentTodayUser');
	}
	public function sendmessage(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}
	
		if(($this->request->data) && Messages::create()->save($this->request->data)) {
			$function = new Functions();
			$reply = (integer) $this->request->data['reply']+1;
			$function->addPoints($this->request->data['user_id'],"Bronze","Send Message",$reply);
			return $this->redirect("Users::accounts");
		}
	}
	public function active(){}
	
	public function transactions(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}
	
		$function = new Functions();
		$user = Session::read('default');
		$wallet = $function->getBalance($user['username']);	
		$listTransactions = $function->listTransactions($user['username'],$wallet['wallet']['address']);
		
		return compact('listTransactions','wallet') ;
	}
	public function interests(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}
		$Interests = Interests::find('all',array(
			'conditions'=>array('user_id'=>$user['_id']),
			'order'=>array('datetime.date'=>'DESC','datetime.time'=>'DESC')
		));
		return compact('Interests');
	}
	public function addprivatekey(){
		$user = Session::read('default');
		$username = $user['username'];
		if(($this->request->data)){
			$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
			$coin = $bitcoin->importprivkey($this->request->data['privatekey'],$this->request->data['username']);

		}
		
		return compact('username','coin');
	}
	public function listusers(){
		$function = new Functions();
		$userlist = $function->listusers();
		$count = Details::count();
		return compact('userlist','count');
	}
	
	public function transfer(){
		$user = Session::read('default');
		if ($user==""){	return $this->redirect('Users::index');}
		if($this->request->data){
			$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
			$address = $this->request->data['address'];
			$amount = number_format($this->request->data['amount'],8);		
			$comment = $this->request->data['comment'];		
			$username = $user['username'];		
			$balance = $bitcoin->sendfrom($username,$address,(float)$amount,(int)1,$comment);
			if(isset($balance['error'])){
				$error = $balance['error']; 
			}else{
				$success = $address;
			}
		}
		
		
		$function = new Functions();
		$user = Session::read('default');
		$wallet = $function->getBalance($user['username']);		
		return compact('wallet','error','success') ;	
	}
	public function withdraw(){
		$user = Session::read('default');
		if ($user==""){	return $this->redirect('Users::index');}
		$function = new Functions();
		$user = Session::read('default');
		$wallet = $function->getBalance($user['username']);
		return compact('wallet') ;			
	}
	public function review(){
		if(in_array('json',$this->request->params['args'])){
			$json = true;
		}

		$user = Session::read('default');
		if ($user==""){	return $this->redirect('Users::index');}

		if($this->request->data){
			Details::find('all',array(
				'conditions'=>array('user_id'=>$user['_id'])
			))->save($this->request->data);
			return $this->redirect('Users::reviews');
		}

		$reviews = Details::find('all',array(
			'fields'=>array('review','username'),
			'conditions'=>array('review.title'=>array('$gt'=>'')),
			'order'=>array('review.datetime.date'=>'DESC'),
			'limit'=>2
		));
		if($json == true){
			return $this->render(array('json' =>  
				compact("reviews"), 
			'status'=> 200));
		}

		return compact('reviews');
	}
	public function reviews($limit = 10){
		if(in_array('json',$this->request->params['args'])){
			$json = true;
		}

		$reviews = Details::find('all',array(
			'fields'=>array('review','username','user_id'),
			'conditions'=>array('review.title'=>array('$gt'=>'')),
			'order'=>array('review.datetime.date'=>'DESC','review.datetime.time'=>'DESC'),
			'limit'=>$limit
		));
		
		
/* 		$mongodb = Connections::get('default')->connection;
		$point = Details::connection()->connection->command(array(
			'aggregate' => 'details',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'point' => '$review.points.point',
					'user_id'=>'$user_id',
					'username'=>'$username'							
				)),
				array('$group' => array( '_id' => array(
						'user_id'=>'$user_id',
						'username'=>'$username',
						),
					'point' => array('$sum' => '$point'),  
				)),
			)
		));
		$average = Details::connection()->connection->command(array(
			'aggregate' => 'details',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'point' => '$review.points.point',
					'user_id'=>'$user_id',
					'username'=>'$username'							
				)),
				array('$group' => array( '_id' => array(
						'user_id'=>'$user_id',
						'username'=>'$username',
						),
					'point' => array('$avg' => '$point'),  
				)),
			)
		));		
 *///		print_r($point);
//		print_r($average);		
		
//		return compact('reviews','point','average');
		if($json == true){
			return $this->render(array('json' =>  
				compact("reviews"), 
			'status'=> 200));
		}

		return compact('reviews');
	}
	public function addvote(){
		$user = Session::read('default');
		if ($user==""){	return $this->render(array('json' => $data = array(), 'status'=> 200));		}
		$user_id = $user['_id'];
		$to_user_id = $this->request->params['args'][0];
		$point = $this->request->params['args'][1];		
		
		$findPoints = Details::find('all',array(
			'fields' => array('review'),
			'conditions' => array('user_id'=>$to_user_id)
		));

		$variable = array();
		$i = 0;
		foreach ($findPoints as $p){
			$variable['review']['title'] =$p['review']['title'];
			$variable['review']['text'] =$p['review']['text'];			
			$variable['review']['datetime']['date'] =$p['review']['datetime']['date'];			
			$variable['review']['datetime']['time'] =$p['review']['datetime']['time'];						
			if(isset($variable['review']['points']['user_id'])){
				array_push($variable['review']['points']['user_id'],$user_id);
				array_push($variable['review']['points']['point'],(int)$point);
			}else{
				$variable['review']['points']['user_id']=$user_id;
				$variable['review']['points']['point']=(int)$point;				
			}
		}

//		print_r($variable);
		Details::find('all',array(
			'conditions' => array('user_id'=>$to_user_id)
		))->save($variable);

		return $this->render(array('json' => $data = array(), 'status'=> 200));		
	}
	public function addfunds(){
		$tickers = Tickers::find('first',array(
			'order' => array(
				'date' => 'DESC'
			)
		));
	
		$user = Session::read('default');
		if ($user==""){	return $this->redirect('Users::index');}
		$functions = new Functions();
		$wallet = $functions->getBalance($user['username']);

		if($this->request->data){
			$deals = Deals::count(array(
				'conditions'=>array(
				'user_id'=> $this->request->data['user_id'],
				'complete'=>'N'
				)
			));
			if($deals==0){
				Deals::create()->save($this->request->data);
				$this->orderEmail($this->request->data);				
				return $this->redirect('users::addfunds');
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
		return compact('wallet','user','tickers');
	}
	
	public function orderEmail($data){
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
					'controller' => 'users',
					'template'=>'order',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("You have ordered BTC from rBitcoin");
			$message->setFrom(array('no-reply@rbitco.in' => 'Order BTC rbitco.in'));
			$message->setTo($user['email']);
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		
			$message->setBody($body,'text/html');
	
			$mailer->send($message);
	}

	public function password(){

		if($this->request->data){

			$details = Details::find('first', array(
				'conditions' => array(
					'key' => $this->request->data['key']
				),
				'fields' => array('user_id')
			));
			$msg = "Password Not Changed!";
//			print_r($details['user_id']);
			if($details['user_id']!=""){
				if($this->request->data['password'] == $this->request->data['password2']){
//					print_r($this->request->data['password']);
					$user = Users::find('first', array(
						'conditions' => array(
							'_id' => $details['user_id'],
							'password' => String::hash($this->request->data['oldpassword']),
						)
					));

					$data = array(
						'password' => $this->request->data['password'],
					);
					$user = Users::find('all', array(
						'conditions' => array(
							'_id' => $details['user_id'],
							'password' => String::hash($this->request->data['oldpassword']),
						)
					))->save($data,array('validate' => false));
					
					if($user){
						$msg = "Password changed!";
					}

				}else{
					$msg = "New password does not match!";
				}
			}
		}

	return compact('msg');
	}

	public function forgotpassword(){
		if($this->request->data){
			$user = Users::find('first',array(
				'conditions' => array(
					'email' => $this->request->data['email']
				),
				'fields' => array('_id')
			));
//		print_r($user['_id']);
			$details = Details::find('first', array(
				'conditions' => array(
					'user_id' => (string)$user['_id']
				),
				'fields' => array('key')
			));
//					print_r($details['key']);exit;
		$key = $details['key'];
		if($key!=""){
		$email = $this->request->data['email'];
			$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));
			$body = $view->render(
				'template',
				compact('email','key'),
				array(
					'controller' => 'users',
					'template'=>'forgot',
					'type' => 'mail',
					'layout' => false
				)
			);

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
	
			$message = Swift_Message::newInstance();
			$message->setSubject("Password reset link from rbitco.in");
			$message->setFrom(array('no-reply@rbitco.in' => 'Password reset email rbitco.in'));
			$message->setTo($user->email);
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		

			$message->setBody($body,'text/html');
			$mailer->send($message);
			}
		}
	}
	public function changepassword($key){
		return compact('key');
	}
	
	public function refer(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}

		$details = Details::find('all',array(
			'conditions'=>array('user_id'=>$user['_id'])
		));
		foreach($details as $d){
			$address = $d['bitcoinaddress'][0];
		}
		return compact('address','details','user');
	}
	public function sendrefer(){
		$user = Session::read('default');
		if ($user==""){		return $this->redirect('Users::index');}
		if($this->request->data) {	
//			print_r($this->request->data);
			$emails = explode("\n",$this->request->data['emails']);
			$personal = $this->request->data['message'];

			$view  = new View(array(
				'loader' => 'File',
				'renderer' => 'File',
				'paths' => array(
					'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
				)
			));

			$details = Details::find('all',array(
				'conditions'=>array('user_id'=>$user['_id'])
			));
			foreach($details as $d){
				$address = $d['bitcoinaddress'][0];
			}
			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);

			foreach($emails as $e){
			$body = $view->render(
				'template',
				compact('e','personal','user','address'),
				array(
					'controller' => 'users',
					'template'=>'refer',
					'type' => 'mail',
					'layout' => false
				)
			);
			$message = Swift_Message::newInstance();
			$message->setSubject($user['username'].', from: '.$user['email']. " through rbitco.in");
			$message->setFrom(array('no-reply@rbitco.in' => 'rbitco.in'));
			$message->setTo($user->$e);
			$message->addBcc(MAIL_1);
			$message->addBcc(MAIL_2);			
			$message->addBcc(MAIL_3);		

			$message->setBody($body,'text/html');
			$mailer->send($message);
			
			}
		}
		return $this->redirect('Users::accounts');
	
	}
}
?>
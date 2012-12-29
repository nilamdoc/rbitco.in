<?php
namespace app\controllers;

use app\extensions\action\Oauth2;
use app\models\Users;
use app\models\Details;

use lithium\security\Auth;
use lithium\storage\Session;
use li3_recaptcha\security\Recaptcha;
use app\models\Functions;
use app\extensions\action\Smslane;
use MongoID;

use \lithium\template\View;
use \Swift_MailTransport;
use \Swift_Mailer;
use \Swift_Message;
use \Swift_Attachment;

class UsersController extends \lithium\action\Controller {

	public function index(){
//		$users = Users::all();
//		return compact('users');
	}
	public function signup() {	
		$user = Users::create();
//		if(($this->request->data) && Recaptcha::check($this->request)){
			if(($this->request->data) && $user->save($this->request->data)) {	
				$verification = sha1($user->_id);
				$data = array('user_id'=>(string)$user->_id,'email.verify' => $verification);
				Details::create()->save($data);

			$email = $this->request->data['email'];
			$name = $this->request->data['firstname'].' '.$this->request->data['lastname'];

		 $view  = new View(array(
            'loader' => 'File',
            'renderer' => 'File',
            'paths' => array(
                'template' => '{:library}/views/{:controller}/{:template}.{:type}.php'
            )
        ));
        $body = $view->render(
            'template',
            compact('email','verification','name'),
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
		return compact(array('user'));
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
		return compact('msg');
	}
	public function settings() {
		$user = Session::read('default');
		$id = $user['_id'];
		
		$details = Details::find('first',
			array('conditions'=>array('user_id'=>$id))
		);

	return compact('details','user');
		
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
	return compact('details');
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
				return compact('id');
			
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
		$user_id = $user['_id'];
		$details = Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			));		
		return compact('details');
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
}
?>
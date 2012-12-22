<?php
namespace app\controllers;
use app\models\Users;
use lithium\security\Auth;
use lithium\storage\Session;
use app\models\Functions;


class UsersController extends \lithium\action\Controller {

	public function index(){
//		$users = Users::all();
//		return compact('users');
	}
	public function signup() {	
		$user = Users::create();
			if(($this->request->data) && $user->save($this->request->data)) {	
			$this->sendverificationemail($user);
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
		if(isset($user['verified'])){
			$msg = "Your email is verified.";
		}else{
			$msg = "Your email is <strong>not</strong> verified. Please check your email to verify.";
			
		}
		return compact('msg');
	}
	public function settings() {	
//		return $this->redirect('Users::index');
	}
	
	
	public function sendverificationemail($user){
	$to = $user['email'];
	$subject = "Verification of email from rbitco.in";
	$message = 'Hi,

Please confirm your email address associated at rbitco.in by clicking the following link:

http://rbitco.in/users/confirm/'.$user['_id'].'

Or use this confirmation code: '.$user['_id'].'

';
		$from = 'no-reply@rbitco.in';
		$headers = "From:" . $from;

		mail('nilam@localhost',$subject,$message,$headers);
		exit;
		return;

	}
}
?>
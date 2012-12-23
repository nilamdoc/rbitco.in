<?php
namespace app\controllers;
use app\models\Users;
use app\models\Details;
use lithium\security\Auth;
use lithium\storage\Session;
use app\models\Functions;
use MongoID;

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
	
	public function confirm($email=null,$id=null){
		if($email == "" || $id==""){
			if($this->request->data){
				if($this->request->data['email']=="" || $this->request->data['verified']==""){
					return $this->redirect('Users::email');
				}
				$email = $this->request->data['email'];
				$id = $this->request->data['verified'];
			}
		}
	$finduser = Users::first(array(
		'conditions'=>array(
			'email' => $email,
			'_id' => $id
		)
	));
	$id = (string) $finduser['_id'];
		if($id!==null){
			$data = array('verified'=>'Yes','user_id'=>$id);
			Details::create();
			$details = Details::find('all',array(
				'conditions'=>array('user_id'=>$id)
			))->save($data);
			if(count($details)==0){
				Details::create($data)->save($data);
			}
			return compact('id');
		}else{return $this->redirect('Users::email');}
	}
	
	public function mobile(){

	$user_id = $this->request->data['user_id'];
		if($this->request->data){
			Details::find('all',array(
				'conditions'=>array('user_id'=>$user_id)
			))->save($this->request->data);

		}
	}
	
	public function sendverificationemail($user){
	$to = $user['email'];
	$subject = "Verification of email from rbitco.in";
	$message = 'Hi,

Please confirm your email address associated at rbitco.in by clicking the following link:

http://rbitco.in/users/confirm/'.$user['email'].'/'.$user['_id'].'

Or use this confirmation code: '.$user['_id'].' for email address: '.$user['email'].'

Thanks
Support rBitcoin
';
		$from = 'no-reply@rbitco.in';
		$headers = "From:" . $from;

		mail($to,$subject,$message,$headers);
//		exit;
		return;

	}
}
?>
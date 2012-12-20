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
			$this->redirect('Users::index');	
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

	public function settings() {	
//		return $this->redirect('Users::index');
	}

}
?>
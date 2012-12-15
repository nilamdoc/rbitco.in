<?php
namespace app\controllers;

use lithium\security\Auth;
use lithium\util\String;
use app\models\Users;
use lithium\storage\Session;

class SessionsController extends \lithium\action\Controller {

    public function add() {
		   //assume there's no problem with authentication
			$noauth = false;
			//perform the authentication check and redirect on success
			Session::delete('default');				
			if (Auth::check('member', $this->request)){
				//Redirect on successful login
				Session::write('default',Auth::check('member', $this->request));
				return $this->redirect('/');
			}
			//if theres still post data, and we weren't redirected above, then login failed
			if ($this->request->data){
				//Login failed, trigger the error message
				$noauth = true;
			}
			//Return noauth status
			return compact('noauth');
			return $this->redirect('/');

        // Handle failed authentication attempts
    }
	 public function delete() {
        Auth::clear('member');
		Session::delete('default');
        return $this->redirect('/');
    }
}
?>
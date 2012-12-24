<?php
namespace app\controllers;
use app\models\api;
use li3_soauth\action\OAuthConsumer;
use li3_soauth\action\OAuthToken;

class ApiController extends \lithium\action\Controller {

	public function index(){
		$OAuthConsumer = new OAuthConsumer('a','b','/');
		print_r(compact('OAuthConsumer'));
		$OAuthToken = new OAuthToken('a','b');
		$OA = $OAuthToken->to_string();
		print_r(compact('OA'));

	}
}
?>
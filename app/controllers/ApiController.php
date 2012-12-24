<?php
namespace app\controllers;
use app\models\api;
use app\extensions\action\OAuthConsumer;
use app\extensions\action\OAuthToken;

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
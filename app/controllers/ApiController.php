<?php
namespace app\controllers;

use app\models\api;
use app\extensions\action\OAuth2;

class ApiController extends \lithium\action\Controller {

	function index(){
		$o = new OAuth2();
		$ox = $o->request_token();
		print_r($ox);
	}

}
?>
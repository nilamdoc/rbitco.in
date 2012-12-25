<?php
namespace app\extensions\action;
use OAuth;
use OAuthProvider;

class OAuth2 extends \lithium\action\Controller {

	public function request_token(){
		return $this->__createConsumer();
	}

	function __createConsumer(){
		$provider = new OAuthProvider("rBitCoin");		
		$key = sha1($provider->generateToken(20,true));
		$secret = sha1($provider->generateToken(20,true));
		return compact('key','secret');
	}
}
?>
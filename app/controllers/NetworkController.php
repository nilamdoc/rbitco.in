<?php
namespace app\controllers;
use \app\extensions\action\Controller;


class NetworkController extends \lithium\action\Controller {

	public function index(){
	  $bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');	
  	  $getblockcount = $bitcoin->getblockcount();

	  $getconnectioncount = $bitcoin->getconnectioncount();
	  $getblockhash = $bitcoin->getblockhash($getblockcount);
	  $getblock = $bitcoin->getblock($getblockhash);
	  return compact('getblockcount','getconnectioncount','getblock');
	}
	public function blocks(){
	
	}
	public function transactions(){
	
	}

}
?>
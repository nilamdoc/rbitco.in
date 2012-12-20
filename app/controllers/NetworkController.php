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
	public function blocks($blockcount = null){
	  $bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');	
	  if (!isset($blockcount)){
	  	  $blockcount = $bitcoin->getblockcount();
	  }else{
	  	$blockcount = intval($blockcount);
	  }
	  if($blockcount<10){$blockcount = 10;}
	  $getblock = array();
	  $getblockhash = array();
	  $j = 0;
	  for($i=$blockcount;$i>$blockcount-10;$i--){
		$getblockhash[$j] = $bitcoin->getblockhash($i);
		$getblock[$j] = $bitcoin->getblock($getblockhash[$j]);
		$j++;
	  }
		return compact('getblock','blockcount');
	}
	public function blockhash($blockhash = null){
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');	
		$blockcount = $bitcoin->getblockcount();
	if (!isset($blockhash)){
		$blockhash = $bitcoin->getblockhash($blockcount);		
		$prevblock = $blockcount - 1;
		$prevblockhash = $bitcoin->getblockhash($prevblock);		
	}else{
		$getblock = $bitcoin->getblock($blockhash);
		$prevblock = $getblock['height'] - 1;
		$prevblockhash = $bitcoin->getblockhash($prevblock);		
		if($getblock['height']<>$blockcount ){
			$nextblock = $getblock['height'] + 1;
			$nextblockhash = $bitcoin->getblockhash($nextblock);		
		
		}
		
	}
	
		$getblock = $bitcoin->getblock($blockhash);

		return compact('getblock','prevblockhash','nextblockhash','prevblock','nextblock');
	}
	
	public function transactionhash($transactionhash = null){
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');		
		$getrawtransaction = $bitcoin->getrawtransaction($transactionhash);
		$decoderawtransaction = $bitcoin->decoderawtransaction($getrawtransaction);
		$listsinceblock = $bitcoin->listsinceblock($transactionhash);
		return compact('decoderawtransaction','listsinceblock');
	}
	
	public function address($address = null){
	
	}
	public function transactions(){
	
	}

}
?>
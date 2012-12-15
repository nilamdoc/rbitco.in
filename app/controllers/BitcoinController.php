<?php
namespace app\controllers;
use \app\extensions\action\Controller;
use \app\extensions\action\BitCoinExchange;

set_time_limit(0);
class BitcoinController extends \lithium\action\Controller  {

public function index(){

	  $bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');
	  $BitExchange = new BitCoinExchange();
	  $tick = $BitExchange->GetRates();
	  print_r($tick);
	  $info = $bitcoin->getinfo();
	  $accounts = $bitcoin->listaccounts(0);
		$i = 0;
		$wallet = array();
	  foreach($accounts as $key=>$val){
	  	  $wallet[$i]['address'] = $bitcoin->getaddressesbyaccount($key);
		  $j = 0;
		  foreach ($wallet[$i]['address'] as $k){
			  $wallet[$i]['privatekey'][$j] = $bitcoin->dumpprivkey($k);
			  $j++;
		  }
		  $wallet[$i]['balance'] = $bitcoin->getbalance($key);
		  $wallet[$i]['key'] = $key; 
		  $i++;
	  }
		$difficulty = $bitcoin->getdifficulty();

	return compact('info','accounts','wallet','difficulty');
}
	public function add($key = null ,$name = null){
		if($key!="" && $name!=""){
			$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');	
			$coin = $bitcoin->importprivkey($key,$name);
			return compact('coin');
		}
	}
}
?>
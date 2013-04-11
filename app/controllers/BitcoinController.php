<?php
namespace app\controllers;

use app\extensions\action\Bitcoin;

set_time_limit(0);
class BitcoinController extends \lithium\action\Controller  {

public function index(){
		$security = $this->request->query['security'];
		if($security!=SECURITY_CHECK ){return $this->redirect('Users::index');}
		
		$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);
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
		$title = "Index of Bitcoin"	;

	return compact('info','accounts','wallet','difficulty','title');
}
	public function add($key = null ,$name = null){
		if($key!="" && $name!=""){
			$bitcoin = new Bitcoin('http://'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT,BITCOIN_WALLET_USERNAME,BITCOIN_WALLET_PASSWORD);		
			$coin = $bitcoin->importprivkey($key,$name,false);
			$title = "Add a new bitcoin"	;			
			return compact('coin','title');
		}
	}
	
}
?>
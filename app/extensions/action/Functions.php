<?php
namespace app\extensions\action;

use app\extensions\action\Controller;

class Functions extends \lithium\action\Controller {

	public function roman($integer, $upcase = true){
		$table = array('M'=>1000, 'CM'=>900, 'D'=>500, 'CD'=>400, 'C'=>100, 'XC'=>90, 'L'=>50, 'XL'=>40, 'X'=>10, 'IX'=>9, 'V'=>5, 'IV'=>4, 'I'=>1);
		$return = '';
		while($integer > 0){
			foreach($table as $rom=>$arb){
				if($integer >= $arb){
					$integer -= $arb;
					$return .= $rom;
					break;
				}
			}
		}
		return $return;
	} 

	public function getBitAddress($account){
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');

	  	  $wallet['address'] = $bitcoin->getaddressesbyaccount($account);
		  $wallet['balance'] = $bitcoin->getbalance($account);
		  $wallet['key'] = $account; 
		return compact('wallet');
	}
	public function sendAmount($fromAccount, $toAddress, $amount, $flag = 1, $message){
		$bitcoin = new Controller('http://'.BITCOIN_WALLET_USERNAME.':'.BITCOIN_WALLET_PASSWORD.'@'.BITCOIN_WALLET_SERVER.':'.BITCOIN_WALLET_PORT.'/');
		
		$sendAmount = $bitcoin->sendfrom($fromAccount, $toAddress, $amount, $flag, $message);
		return compact('sendAmount');
	}

	public function gettransactions($address=null)
	{
	//echo $fromcurrency;
	if ( $address == "" ){return;}
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
		$json = file_get_contents('http://blockexplorer.com/q/mytransactions/'.$address, false, $context);
//			print_r($json);
			$jdec = json_decode($json);
//			print_r($jdec);
//			$rate = $jdec->{'ticker'}->{'avg'};
			return (array)$jdec;
	}

	public function addressfirstseen($address=null)
	{
	//echo $fromcurrency;
	if ( $address == "" ){return;}
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://blockexplorer.com/q/addressfirstseen/'.$address, false, $context);
			return $json;
	}

	public function addressbalance($address=null)
	{
	//echo $fromcurrency;
	if ( $address == "" ){return;}
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://blockexplorer.com/q/addressbalance/'.$address, false, $context);
			return $json;
	}

	function get_ip_address() {
		foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				foreach (explode(',', $_SERVER[$key]) as $ip) {
					if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
						return $ip;
					}
				}
			}
		}
	}

	public function ip_location($ip=null){
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://api.hostip.info/get_json.php?ip='.$ip.'&position=true', false, $context);
			$jdec = (array)json_decode($json);			
			return compact('jdec');
	}

	public function toFriendlyTime($seconds) {
	  $measures = array(
		'day'=>24*60*60,
		'hour'=>60*60,
		'minute'=>60,
		'second'=>1,
		);
	  foreach ($measures as $label=>$amount) {
		if ($seconds >= $amount) {  
		  $howMany = floor($seconds / $amount);
		  return $howMany." ".$label.($howMany > 1 ? "s" : "");
		}
	  } 
	  return "now";
	}   
}
?>
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

}
?>
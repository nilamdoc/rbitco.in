<?php
namespace app\extensions\action;
use lithium\action\DispatchException;

class BitCoinExchange extends \lithium\action\Controller {

	public function GetRates(){
		$json = file_get_contents("https://mtgox.com/api/1/BTCUSD/ticker");
		return json_decode($json,true);
	}

}
?>
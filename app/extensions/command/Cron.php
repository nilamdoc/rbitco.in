<?php
namespace app\extensions\command;
use app\models\Tickers;
class Cron extends \lithium\console\Command {

    public function run() {
		$ticker = array();
		$ticker = $this->mtGoxRate('USD');
//		$google = $this->googleRate();
		$openExchangeRate = $this->openExchangeRate();
		$ticker['date']= new \MongoDate();		
		$ticker['INR'] = floatval($openExchangeRate);

		$tickers = Tickers::create();
		$tickers->save($ticker);
    }

	public function googleRate(){
	$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://www.google.com/ig/calculator?hl=en&q=1USD=?INR', true, $context);
			return substr($json, strrpos($json,'rhs: ')+6,10); 
	}
	
	public function openExchangeRate(){
	$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://openexchangerates.org/api/latest.json?app_id=8fbd125c448944b286ec490c6397d3d8', true, $context);
			$rates = json_decode($json,true);

			return 	$rates['rates']['INR'];
	}

// 
	public function mtGoxRate($fromcurrency="USD")
	{
	//echo $fromcurrency;
	if ( $fromcurrency == "usd" ) $fromcurrency = "USD";
	if ( $fromcurrency == "eur" ) $fromcurrency = "EUR";
	
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('https://mtgox.com/api/0/data/ticker.php?Currency='.$fromcurrency, false, $context);
			//print_r($json);
			$jdec = json_decode($json);
			//print_r($jdec);
			$rate = $jdec->{'ticker'}->{'avg'};
			return (array)$jdec;
	}
}

?>
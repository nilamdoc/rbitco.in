<?php
namespace app\extensions\command;
use app\models\Tickers;
class Cron extends \lithium\console\Command {

// hourly cron job for getting exchange rates

    public function run() {
		$ticker = array();
		$ticker = $this->mtGoxRate('USD');
//		$google = $this->googleRate();
		$openExchangeRate = $this->openExchangeRate();
		$ticker['date']= new \MongoDate();		
		$ticker['INR'] = floatval($openExchangeRate);
print_r($ticker);
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
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL,'http://www.google.com/ig/calculator?hl=en&q=1USD=?INR');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//$json = curl_exec($ch);
curl_close($ch);			
			
			return substr($json, strrpos($json,'rhs: ')+6,10); 
	}
	
	public function openExchangeRate(){
	$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$json = file_get_contents('http://openexchangerates.org/api/latest.json?app_id=8fbd125c448944b286ec490c6397d3d8', true, $context);
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL,'http://openexchangerates.org/api/latest.json?app_id=8fbd125c448944b286ec490c6397d3d8');
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//$json = curl_exec($ch);
curl_close($ch);			
			
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
			$json = file_get_contents('https://data.mtgox.com/api/0/data/ticker.php?Currency='.$fromcurrency, false, $context);
$ch = curl_init();
$timeout = 5; // set to zero for no timeout
curl_setopt ($ch, CURLOPT_URL,'https://mtgox.com/api/0/data/ticker.php?Currency='.$fromcurrency);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
//$json = curl_exec($ch);
curl_close($ch);			

//			print_r($json);
			$jdec = json_decode($json);
			//print_r($jdec);
			$rate = $jdec->{'ticker'}->{'avg'};
			return (array)$jdec;
	}
}
?>
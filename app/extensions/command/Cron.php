<?php
namespace app\extensions\command;
use app\models\Tickers;
class Cron extends \lithium\console\Command {

    public function run() {
		$ticker = array();
		$ticker = $this->mtGoxRate('USD');
		$google = $this->googleRate();
		$ticker['date']= new \MongoDate();		
		$ticker['INR'] = $google;
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
			print_r($json);
			$nilam = json_decode($json,true, JSON_BIGINT_AS_STRING);
			var_dump($nilam);
			return substr($json, strrpos($json,'rhs: ')+6,10); 
	}


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
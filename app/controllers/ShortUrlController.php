<?php 
namespace app\controllers;
use app\models\Urls;
use li3_qrcode\extensions\action\QRcode;

class ShortURLController extends \lithium\action\Controller {

	public function index(){
		$params = $this->request->params;
//		print_r( $params);
		$qr = false;
		$be = false;		
		$dataout = "";
		if(count($params['args'])==0){					
			$dataout = "No such short code or Bitcoin address!";
			return $this->render(array('text' => $dataout, 'status'=> 200));			
			}
		if(isset($params['args'][1])){
			if($params['args'][1]=='qr'){
				// create qrcode for the address
				$qr = true;
			}
			if($params['args'][1]=='be'){
				// create qrcode for the address
				$be = true;
			}

		}
		if(strlen($params['args'][0])<10){
			// convert to bitaddress
			$short = $params['args'][0];
				$data = Urls::find('all',
					array('conditions'=>array('short' => $short),
					'fields'=>(array('short','address'))
					)
				);
				foreach ($data as $d){
					$shorten = $d['address'];
				}
				if(!isset($shorten)){
					$dataout = "No such short code!";
					return $this->render(array('text' => $dataout, 'status'=> 200));			
				}
			$dataout = $shorten;			

			if($qr==false && $be==false){
				return $this->render(array('text' => $dataout, 'status'=> 200));
			}else{
				if($qr==true){
					$qrcode = new QRcode();
					$qrcode->png($shorten, QR_OUTPUT_DIR.$shorten.'.png', 'H', 7, 2);
					$dataout = "<img src='".QR_OUTPUT_RELATIVE_DIR.$shorten."'>";
					return compact('shorten');
				}
				if($be==true){
					$shorten = $url;
					$this->redirect("http://www.blockexplorer.com/address/".$shorten);					
					return compact('shorten');
				}
			}
		}else{
			// convert to shoururl
			$url = $params['args'][0];
			$conflicts = Urls::count(array('address' => $url));
			if($conflicts==0){
				$shorten = $this->Code(3);
				$data = array('address'=>$url,'short'=>$shorten);
				Urls::create()->save($data);
			}else{
				$data = Urls::find('all',
					array('conditions'=>array('address' => $url),
					'fields'=>(array('short','address'))
					)
				);
				foreach ($data as $d){
					$shorten = $d['short'];
				}
			}
			$dataout = $shorten;
			if($qr==false && $be==false){
				return $this->render(array('text' => $dataout, 'status'=> 200));			
			}else{
				if($qr==true){
					$shorten = $url;
					$qrcode = new QRcode();
					$qrcode->png($shorten, QR_OUTPUT_DIR.$shorten.'.png', 'H', 7, 2);
					$dataout = "<img src='".QR_OUTPUT_RELATIVE_DIR.$shorten."'>";
					return compact('shorten');
				}
				if($be==true){
					$shorten = $url;
					$this->redirect("http://www.blockexplorer.com/address/".$shorten);					
					return compact('shorten');
				}
			}
		}


	}

	public function get(){
		if(isset($this->request->data['address'])){
			$address = $this->request->data['address'];
			$opts = array(
			  'http'=> array(
					'method'=> "GET",
					'user_agent'=> "MozillaXYZ/1.0"));
			$context = stream_context_create($opts);
			$shorten = trim(file_get_contents('http://rbitco.in/s/'.$address, false, $context));
			return compact('shorten','address');
		}
	}
	
	public function Code($length=6){
			$chars = "1234567890abcdefghijkmnopqrstuvwxyz";
			$i = 0;
			$password = "";
			while ($i <= $length) {
				$password .= $chars{mt_rand(0,strlen($chars))};
				$i++;
			}
		return $password;			
		}

}
?>
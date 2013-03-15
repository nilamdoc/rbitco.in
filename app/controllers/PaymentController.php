<?php
namespace app\controllers;
use lithium\security\Auth;
use lithium\storage\Session;
use app\models\Users;
use app\models\Details;
use app\models\Tickers;

use app\extensions\action\Functions;


class PaymentController extends \lithium\action\Controller {

	public function index(){
		if ($this->request->data && Auth::check('member', $this->request)) {
			Session::write('default',Auth::check('member', $this->request));
			return $this->redirect('payment::send');	
		}
	
		$params = $this->request->params;
//		print_r($params);
		$refer = $params['args'][0].'/'.$params['args'][1].'/'.$params['args'][2].'/'.$params['args'][3].'/'.$params['args'][4].'/'.$params['args'][5].'/'.$params['args'][6];
		$key = $params['args'][2];
		$key2 = strrev($params['args'][3]);		
		$referrer = str_replace('---','/',$params['args'][4]);				
		if($key!=$key2){
			$wrong = 'Yes';
			return $this->render(array('layout' => 'plain', 'data'=>compact('wrong','referrer')));	
		}
		$details = Details::find('first',
			array('conditions'=>array('buttons.key'=>$key))
		);
		foreach($details['buttons'] as $b){

			if($b['key']==$key){
				$value = $b['amount'];
				$currency = $b['currency'];				
				$product = $b['product'];
				$key = $b['key'];
				$success_url = $b['success_url'];
				$cancel_url = $b['cancel_url'];
				
			}
		}
		
		return $this->render(array('layout' => 'plain', 'data'=>compact('refer','details','value','currency','product','referrer')));	
	}

	public function send($key = null){
		$referrer = $_SERVER['HTTP_REFERER'];
		$title = "Payment";
		$refer = $this->request->url;
		$params = $this->request->params;
		$key = $params['args'][0];

		$details = Details::find('first',
			array('conditions'=>array('buttons.key'=>$key))
		);
		
		foreach($details['buttons'] as $b){

			if($b['key']==$key){
				$value = $b['amount'];
				$currency = $b['currency'];				
				$product = $b['product'];
				$key = $b['key'];
				$success_url = $b['success_url'];
				$cancel_url = $b['cancel_url'];
				
			}
		}
		$user = Session::read('default');
		if ($user==""){
			$referrer = str_replace('/','---',($_SERVER['HTTP_REFERER']));
			return $this->redirect('/payment/index/'.$refer.'/'.strrev($key).'/'.$referrer);
			}
		$id = $user['_id'];

		$tickers = Tickers::find('first',array(
			'order' => array(
				'date' => 'DESC'
			)
		));
		$USD = $tickers['ticker']['avg'];
		$USR = $tickers['INR'];
		$BTC = 1/$USD;
/*		print_r($USD."<br>");
		print_r($USR."<br>");
		print_r($BTC."<br>");
*/
		if($currency=='INR'){
			$addBTC = round( $value *$BTC / $USD ,8);
		}else{
			$addBTC = round(11 ,8);
		}
//print_r($addBTC);
 		$function = new Functions();
		$sumAccounts = $function->sumAccounts((string)$details['user_id']);

		return $this->render(array('layout' => 'plain', 'data'=>compact('title','user','details','sumAccounts','value','currency','product','referrer','addBTC','success_url','cancel_url')));
	
	}

}
?>
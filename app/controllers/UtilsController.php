<?php
namespace app\controllers;
use lithium\storage\Session;

class UtilsController extends \lithium\action\Controller {

	public function index(){
	
	}
	public function currency($currency){
		Session::write('currency',$currency);
		return $this->render(array('json' => $data = array(), 'status'=> 200));
	}
	public function merchant(){
	
	}

}
?>
<?php
namespace app\controllers;


class ToolsController extends \lithium\action\Controller {

	public function index(){
		$title = "Tools ";
		return compact('title');
	
	}
	public function api(){

		$title = "API ";
		return compact('title');
	
	}
	public function merchant(){
		$title = "Merchant Tools ";
		return compact('title');
	
	}

}
?>
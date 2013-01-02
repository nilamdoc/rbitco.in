<?php
namespace app\controllers;

class ArticlesController extends \lithium\action\Controller {

	public function index(){
		$title = "Articles"	;
		return compact('title');
	}
	public function security(){
		$title = "Security"	;
		return compact('title');	
	}
	public function privacy(){
		$title = "Privacy Policy"	;
		return compact('title');	
	
	}
	public function faq(){
		$title = "FAQ: Frequently asked questions"	;
		return compact('title');	
	
	
	}
	public function whyuse_rBitCoin(){
		$title = "Why use bitcoins?"	;
		return compact('title');	
	
	}
}
?>
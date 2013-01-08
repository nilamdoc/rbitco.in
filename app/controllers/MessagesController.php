<?php
namespace app\controllers;
use app\extensions\action\Functions;

class MessagesController extends \lithium\action\Controller {

	public function index(){
		$function = new Functions();
		$countMails = $function->countMails();
		$countReadMails = $function->countReadMails();		
		$countSendMails = $function->countSendMails();				
		
		return compact('countMails','countReadMails','countSendMails');
	}
}
?>
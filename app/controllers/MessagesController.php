<?php
namespace app\controllers;
use app\extensions\action\Functions;
use app\models\Messages;
use MongoID;

class MessagesController extends \lithium\action\Controller {

	public function index(){
		$function = new Functions();
		$countMails = $function->countMails();
		$countReadMails = $function->countReadMails();		
		$countSendMails = $function->countSendMails();				
		
		$getMails = $function->getMails();
		$getReadMails = $function->getReadMails();		
		$getSendMails = $function->getSendMails();				
		
		return compact('countMails','countReadMails','countSendMails','getMails','getReadMails','getSendMails');
	}
	
	public function markasread($id = null,$read = null){
		$data = array('read'=>1);
		Messages::find('all',array(
			'conditions'=>array('_id'=>$id)
		))->save($data);
		return $this->redirect("Messages::index");
	}

	public function markasdelete($id = null){
		$id = new MongoID($id);
		Messages::remove(array('_id'=>$id));
		return $this->redirect("Messages::index");
	}

}
?>
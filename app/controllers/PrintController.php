<?php
namespace app\controllers;
use \lithium\template\View;
use app\extensions\action\Functions;
use app\models\Denominations;


class PrintController extends \lithium\action\Controller {

	public function index(){
		$denominations = Denominations::find('all',array(
			'order' => array('denomination'=>'ASC')
		));
		return compact('denominations')	;
	}
	public function view($id){
	
	$denomination = Denominations::first(array(
			'conditions'=>array('_id'=> $id)
		));

	$view  = new View(array(
		'paths' => array(
			'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
			'layout'   => '{:library}/views/layouts/{:layout}.{:type}.php',
		)
	));
	echo $view->render(
		'all',
		compact('denomination'),
		array(
			'controller' => 'print',
			'template'=>'envelop',
			'type' => 'pdf',
			'layout' =>'mypdf'
		)
	);	
	}

	public function edit($id){
		$denomination = Denominations::first(array(
				'conditions'=>array('_id'=> $id)
			));
		return compact('denomination');
	}

	public function save(){
		if($this->request->data){
			$data = array(
				'btc.x' => $this->request->data['btc_x'],
				'btc.y' => $this->request->data['btc_y'],				
				'btcword.x' => $this->request->data['btcword_x'],
				'btcword.y' => $this->request->data['btcword_y'],				
				'address.x' => $this->request->data['address_x'],
				'address.y' => $this->request->data['address_y'],				
				'address.w' => $this->request->data['address_w'],
				'address.h' => $this->request->data['address_h'],
				'addressstr.x' => $this->request->data['addressstr_x'],
				'addressstr.y' => $this->request->data['addressstr_y'],				
				'private.x' => $this->request->data['private_x'],
				'private.y' => $this->request->data['private_y'],				
				'private.w' => $this->request->data['private_w'],
				'private.h' => $this->request->data['private_h'],
				'privatestr.x' => $this->request->data['privatestr_x'],
				'privatestr.y' => $this->request->data['privatestr_y'],
				'btcpos.x' => $this->request->data['btcpos_x'],
				'btcpos.y' => $this->request->data['btcpos_y']

			);
		
			$denomination = Denominations::first(array(
				'conditions'=>array('_id'=> (string)$this->request->data['_id'])
			))->save($data);
		}	
		$this->redirect(array('controller'=>'print','action'=>'view/'.(string)$this->request->data['_id']));			
	}

	public function order(){
		$denominations = Denominations::find('list',array(
			'fields' => array('denomination'),
			"order"=>"denomination ASC"
		));
		
//		$volumes = Volumes::find('list',array("fields"=>"name","order"=>"number ASC"));
				
		return compact('denominations');
	}


}
?>
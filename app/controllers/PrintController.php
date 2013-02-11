<?php
namespace app\controllers;
use \lithium\template\View;
use app\extensions\action\Functions;
use app\models\Denominations;


class PrintController extends \lithium\action\Controller {

	public function index(){
		$denominations = Denominations::find('all',array(
			'sort' => array('denomination'=>'ASC')
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
			'template'=>'view',
			'type' => 'pdf',
			'layout' =>'mypdf'
		)
	);	
	}

	public function request(){
	}

	public function authorize(){
	}

	public function access(){
	}


}
?>
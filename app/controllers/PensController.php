<?php
namespace app\controllers;
use li3_qrcode\extensions\action\QRcode;
use \lithium\template\View;
use app\models\Pens;
class PensController extends \lithium\action\Controller {

	public function index(){
	}

	public function read(){
		$file = file_get_contents("E:\VanityBit\pen.txt");
		$order = array();
		$addressdata = array();
		$addresses = array();
		$qrcode = new QRcode();		
		$fc = explode("Pattern: 1P", $file );
		Pens::remove();
			foreach($fc as $key=>$value){
				$strings = explode("Address: ", $value );
				$keys = explode("Privkey: ", $strings[1] );
					if($keys[0]!=""){
					$addressdata = array(
						'address' => str_replace("\r\n","",$keys[0]),
						'key' => str_replace("\r\n","",$keys[1]),
						'printed'=>'N'
					);
					Pens::create()->save($addressdata);
					}
				}
		
			$pens = Pens::find('all');
			foreach ($pens as $p){
				$qrcode->png($p['address'], QR_OUTPUT_DIR.$p['address'].'.png', 'H', 7, 2);			
				$qrcode->png($p['key'], QR_OUTPUT_DIR.$p['key'].'.png', 'H', 7, 2);
			}
	
	}

	public function printpen(){
		$pens = Pens::find('all');
		$i = 0;
		foreach ($pens as $p){
			$data[$i]['address'] = $p['address'];
			$data[$i]['key'] = $p['key'];
			$i++;
		}
		$view  = new View(array(
		'paths' => array(
			'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
			'layout'   => '{:library}/views/layouts/{:layout}.{:type}.php',
		)
		));
		echo $view->render(
		'all',
		compact('data'),
		array(
			'controller' => 'pens',
			'template'=>'pens',
			'type' => 'pdf',
			'layout' =>'print'
		)
		);	
	$data = array('printed'=>'Y');
	$pens = Pens::find('all',array(
		'conditions'=>array('printed'=>'N'),
		'limit'=> 1
	))->save($data);

	}

}
?>
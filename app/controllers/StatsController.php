<?php
namespace app\controllers;

use app\models\Bitcoins;
use app\models\Blocks;
use app\models\Users;
use app\models\Accounts;
use lithium\data\Connections;
use app\extensions\action\Functions;

class StatsController extends \lithium\action\Controller {

	public function index(){
	$bitcoins = Bitcoins::find('all', array(
		'order'=>array('height'=>'ASC')
	));

	foreach($bitcoins as $b){	
		$Graphdata = $Graphdata . "['".$b['year']."',".$b['start']."],\n";
	}
		return compact('bitcoins','Graphdata');
	
	}

	public function blocks(){
		\MongoCursor::$timeout = -1;	
		$mongodb = Connections::get('default')->connection;
		$blocks = Blocks::connection()->connection->command(array(
			'aggregate' => 'blocks',
			'pipeline' => array( 
				array( '$project' => array(
					'_id'=>0,
					'version'=>'$version',
					'year' => array('$year' => '$time'),
					'month' => array('$month' => '$time'),                               
//					'day' => array('$dayOfMonth' => '$time'),
				)),

				array('$group' => array( '_id' => array(
						'version'=>'$version',
						'year'=>'$year',
						'month'=>'$month',
//						'day'=>'$day',

					),
					'count' => array('$sum'=>1),
				)),
				array('$sort'=>array(
					'year'=>1,
					'month'=>1,
//					'day'=>1,
				))
			)
		));
		array_multisort($blocks['result'], SORT_ASC);
		$Graphdata = "\n";
		foreach($blocks['result'] as $b){
//		print_r($b);
			$Graphdata = $Graphdata ."['".$b['_id']['year']."-".$b['_id']['month']."',".round($b['count'],2)."],\n";
		}
		return compact('Graphdata');
	}
	
	public function transactions(){
		\MongoCursor::$timeout = -1;	
		$mongodb = Connections::get('default')->connection;
		$blocks = Blocks::connection()->connection->command(array(
			'aggregate' => 'blocks',
			'pipeline' => array( 

				array('$unwind'=>'$txid'),
				array( '$project' => array(
					'_id'=>0,
					'version'=>'$version',
					'year' => array('$year' => '$time'),
					'month' => array('$month' => '$time'),                               
					'txaddresses' => '$txid.vout.scriptPubKey.addresses',
				)),

				array('$group' => array( '_id' => array(
						'version'=>'$version',
						'year'=>'$year',
						'month'=>'$month',
						'txaddresses' => '$txid.vout.scriptPubKey.addresses',

					),
					'count' => array('$sum'=>1),

				)),
				array('$sort'=>array(
					'year'=>1,
					'month'=>1,
//					'day'=>1,
				))
			)
		));
//		print_r($blocks);
		array_multisort($blocks['result'], SORT_ASC);
		$Graphdata = "\n";
		foreach($blocks['result'] as $b){
			$Graphdata = $Graphdata ."['".$b['_id']['year']."-".$b['_id']['month']."',".round($b['count'],2)."],\n";
		}
		return compact('Graphdata');

	}
	
	public function addresses(){
		$url = "http://blockchain.info/charts/n-unique-addresses?format=json&timespan=all";
		$function = new Functions();
		$addresses = $function->blockchain($url);
		$addresses = $function->objectToArray($addresses);
		$i = 0;
		foreach($addresses['values'] as $address){
			$values = $function->objectToArray($address);
			$data[$i]['date'] = date('Y-m-d',$values['x']);
			$data[$i]['value'] = $values['y'];
			$data[$i]['cumm'] = $data[$i-1]['cumm'] + $values['y'];
			$i++;
		}
		foreach($data as $d){
			$Graphdata = $Graphdata ."['".$d['date']."',".$d['cumm']."],\n";
		}
		
		return compact('Graphdata');
	}

	public function users(){
		\MongoCursor::$timeout = -1;	
		$mongodb = Connections::get('default')->connection;
		$users = Users::connection()->connection->command(array(
			'aggregate' => 'users',
			'pipeline' => array( 

				array( '$project' => array(
					'_id'=>0,
					'year' => array('$year' => '$created'),
					'month' => array('$month' => '$created'),                               
					'date' => array('$dayOfMonth' => '$created'),                               					
				)),

				array('$group' => array( '_id' => array(
						'year'=>'$year',
						'month'=>'$month',
						'date'=>'$date'
					),
					'count' => array('$sum'=>1),

				)),
				array('$sort'=>array(
					'year'=>1,
					'month'=>1,
					'date'=>1,
				))
			)
		));
//		print_r($users);
		array_multisort($users['result'], SORT_ASC);
		$Graphdata = "\n";
		$total = 0;
		foreach($users['result'] as $b){
			$total = $total + round($b['count'],2);
			$Graphdata = $Graphdata ."['".$b['_id']['year']."-".$b['_id']['month']."-".$b['_id']['date']."',".round($b['count'],2).",".$total."],\n";
		}
		return compact('Graphdata');
	
	}

}
?>
<?php
namespace app\controllers;

use app\models\Bitcoins;
use app\models\Blocks;
use lithium\data\Connections;

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

}
?>
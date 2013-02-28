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

	public function transactions(){
	
		$mongodb = Connections::get('default')->connection;
		$blocks = Blocks::connection()->connection->command(array(
      'aggregate' => 'blocks',
      'pipeline' => array( 

						array('$unwind'=>'$tx'),

						array('$group' => array( '_id' => array(
                                'version'=>'$version',
                                'year'=> array('$year'=>'$time'),
                                'month'=>'$month',
                            ),
							'count' => array('$sum'=>1),
                        )),
				
    )));
print_r($blocks);
	}

}
?>
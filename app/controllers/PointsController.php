<?php
namespace app\controllers;
use app\extensions\action\Functions;
use app\extensions\action\Pivot;
use lithium\storage\Session;
use app\models\Payments;
use app\models\Users;

class PointsController extends \lithium\action\Controller {

	public function index(){
		$payments = Payments::all();
		$user = Session::read('member');
		$function = new Functions();
		$pointsBronze = 0;
		$pointsSilver = 0;
		$pointsGold = 0;
		if(isset($user)){
			$countPointsBronze = $function->countPoints($user['_id'],'Bronze');
			if(count($countPointsBronze['points']['result'])==0){$pointsBronze = 0;}else{$pointsBronze=$countPointsBronze['points']['result'][0]['points'];}
			$countPointsSilver = $function->countPoints($user['_id'],'Silver');
			if(count($countPointsSilver['points']['result'])==0){$pointsSilver = 0;}else{$pointsSilver=$countPointsSilver['points']['result'][0]['points'];}					
			$countPointsGold = $function->countPoints($user['_id'],'Gold');
			if(count($countPointsGold['points']['result'])==0){$pointsGold = 0;}else{$pointsGold=$countPointsGold['points']['result'][0]['points'];}					
			
		}
	
	
		$function = new Functions();
		$countPointsAll = $function->countPointsAll();
		$countPA = array();
		foreach($countPointsAll['points']['result'] as $c){
		$user = Users::find('first',array(
			'fields'=>array('username'),
			'conditions'=>array('_id'=>$c['_id']['user_id'])
		));

			$data['type'] = $c['_id']['type'];
			$data['user_id'] = $c['_id']['user_id'];			
			$datax['name'] = $user['username'];			
			$data['points'] = $c['points'];			
			array_push($countPA,$data);
		}

	$pivot = new Pivot($countPA);
	$data = $pivot->factory($countPA)
    	->pivotOn(array('name','user_id'))
	    ->addColumn(array('type'), array('points'))
    	->fetch();	
	$countPointsAll = $data;
	
		$sortArray = array();
		foreach($countPointsAll as $person){
			foreach($person as $key=>$value){
				if(!isset($sortArray[$key])){
					$sortArray[$key] = array();
				}
				$sortArray[$key][] = $value;
			}
		} 		
		$orderby = 'Gold__points';

		array_multisort($sortArray[$orderby],SORT_DESC,$countPointsAll); 

	
	
		return compact('countPointsAll','pointsBronze','pointsSilver','pointsGold','payments');
	}
}
?>
<?php
namespace app\controllers;
use app\extensions\action\Functions;
use app\extensions\action\Pivot;
use lithium\storage\Session;

class PointsController extends \lithium\action\Controller {

	public function index(){
	
		$user = Session::read('member');
		$function = new Functions();
		$pointsBronze = 0;
		$pointsSilver = 0;
		$pointsBlack = 0;
		if(isset($user)){
			$countPointsBronze = $function->countPoints($user['_id'],'Bronze');
			if(count($countPointsBronze['points']['result'])==0){$pointsBronze = 0;}else{$pointsBronze=$countPointsBronze['points']['result'][0]['points'];}
			$countPointsSilver = $function->countPoints($user['_id'],'Silver');
			if(count($countPointsSilver['points']['result'])==0){$pointsSilver = 0;}else{$pointsSilver=$countPointsSilver['points']['result'][0]['points'];}					
			$countPointsBlack = $function->countPoints($user['_id'],'Black');
			if(count($countPointsBlack['points']['result'])==0){$pointsBlack = 0;}else{$pointsBlack=$countPointsBlack['points']['result'][0]['points'];}					
			
		}
	
	
		$function = new Functions();
		$countPointsAll = $function->countPointsAll();
		$countPA = array();
		foreach($countPointsAll['points']['result'] as $c){
			$data['type'] = $c['_id']['type'];
			$data['user_id'] = $c['_id']['user_id'];			
			$data['name'] = $c['_id']['name'];			
			$data['points'] = $c['points'];			
			array_push($countPA,$data);
		}

	$pivot = new Pivot($countPA);
	$data = $pivot->factory($countPA)
    	->pivotOn(array('name','user_id'))
	    ->addColumn(array('type'), array('points'))
    	->fetch();	
	$countPointsAll = $data;
		return compact('countPointsAll','pointsBronze','pointsSilver','pointsBlack');
	}
}
?>